class Class {
    static add(el, ...args) {
        for (let c of args) {
            el.classList.add(c.trim());
        }
    }
    static toggle(el, ...args) {
        for (let c of args) {
            el.classList.toggle(c.trim());
        }
    }
    static remove(el, ...args) {
        for (let c of args) {
            el.classList.remove(c.trim());
        }
    }
}
class Select {
    constructor() {
        let targets = [...document.querySelectorAll(`[${Select._trigger}]`)];
        if (Select._el)
            targets = [...targets, ...(Array.isArray(Select._el) ? Select._el : [Select._el])];
        if (!targets.length)
            return;
        for (let i = 0; i < targets.length; i++) {
            const current = targets[i];
            if (current.multiple) {
                current.data = [];
                current.xname = current.name;
                current.removeAttribute("name");
            }
            Class.add(current, "_hidden");
            const wrapper = document.createElement("div");
            Class.add(wrapper, "_relative", "x-custom-select");
            wrapper.innerHTML = Select._template(current.getAttribute("placeholder"));
            const search = wrapper.querySelector('input[type="search"]');
            const display = wrapper.querySelector("[contenteditable]");
            const container = wrapper.querySelector("[x-wrap]");
            const button = wrapper.querySelector("button");
            const list = wrapper.querySelector("ul");
            container.removeAttribute("x-wrap");
            current.addEventListener("click", () => {
                display.click();
            });
            search.addEventListener("input", e => {
                const filter = e.target.value.toUpperCase().trim();
                for (let item of wrapper.querySelectorAll("li:not(.header)")) {
                    const phrase = item.innerText.toUpperCase().trim();
                    for (const niddle of filter.split(" ")) {
                        if (phrase.includes(niddle))
                            Class.remove(item, "_hidden");
                        else
                            Class.add(item, "_hidden");
                    }
                }
            });
            for (let el of[display, button]) {
                el.addEventListener("click", (e) => {
                    e.preventDefault();
                    Select._toggle({
                        container: container,
                        current: current,
                        search: search,
                        list: list,
                    });
                });
            }
            const config = {
                childList: true,
                subtree: true,
                attributes: true
            };
            const observer = new MutationObserver(() => {
                Select._execute({
                    container: container,
                    search: search,
                    input: display,
                    current: current,
                    list: list,
                });
            });
            Select._execute({
                container: container,
                search: search,
                input: display,
                current: current,
                list: list,
            });
            observer.observe(current, config);
            current.insertAdjacentElement("afterend", wrapper);
            current.removeAttribute(Select._trigger);
            wrapper.append(current);
        }
    }
    static option(opts) {
        this._trigger = opts.trigger || "x-select";
        this._el = opts.el || null;
        this._style = {
            color: opts.style.color || "#FFFFFF",
            background: opts.style.background || "#60A5FA",
        };
    }
    static _toggle(el) {
        for (let item of el.list.children) {
            Class.remove(item, "_hidden");
        }
        Class.toggle(el.container, "_hidden", "_flex");
        Class.remove(el.container, "_lg:top-full", "_lg:bottom-full");
        var _ = ((window.innerHeight - el.container.getBoundingClientRect().top) < el.container.clientHeight) ? "lg:bottom-full" : "lg:top-full";
        Class.add(el.container, _);
        el.container.scrollTop = 0;
        el.search.value = "";
        el.current.dispatchEvent(new CustomEvent('toggle', {
            bubbles: true,
        }));
    }
    static _select(el, i = 0) {
        if (el.current.multiple) {
            if (el.target.hasAttribute("style")) {
                const i = el.current.data.indexOf(el.option);
                el.current.data.splice(i, 1);
                el.target.removeAttribute("style");
            } else {
                el.target.style.backgroundColor = Select._style.background;
                el.target.style.color = Select._style.color;
                !el.current.data.includes(el.option) && el.current.data.push(el.option);
            }
            el.input.innerHTML = el.current.data.map(e => `<span class="_rounded-sm _text-xs _p-1" style="color: ${Select._style.color};background: ${Select._style.background}">${e.innerText.trim()}</span>`).join("").trim();
            [...el.container.querySelectorAll("[x-select-input]")].forEach(e => e.remove());
            el.current.data.forEach(e => {
                el.container.insertAdjacentHTML('beforeend', `<input x-select-input type="_hidden" value="${e.value}" name="${el.current.xname}"/>`);
            });
        } else {
            el.current.selectedIndex = i;
            el.input.innerText = el.target.innerText.trim();
            for (let item of el.list.children) {
                item.removeAttribute("style");
            }
            el.target.style.backgroundColor = Select._style.background;
            el.target.style.color = Select._style.color;
        }
    }
    static _execute(el) {
        el.list.innerHTML = "";
        const options = [...el.current.querySelectorAll(":scope > option")].map(op => {
            op.padd = "";
            return op;
        });
        const groups = el.current.querySelectorAll("optgroup");
        if (groups.length) {
            for (let group of groups) {
                options.push({
                    text: group.label,
                    head: true
                }, ...[...group.querySelectorAll("option")].map(op => {
                    op.padd = "_px-4 ";
                    return op;
                }));
            }
        }
        if (options.length < 10) {
            el.search.remove();
        }
        for (let i = 0; i < options.length; i++) {
            const option = options[i];
            const index = [...el.current.options].indexOf(option);
            if (option.head) {
                const item = document.createElement("li");
                item.className = "_text-gray-900 _text-md _px-2 _py-1 _font-black header";
                item.innerHTML = option.text.trim();
                el.list.append(item);
            } else {
                if (!option.innerText.trim().length)
                    continue;
                const item = document.createElement("li");
                item.className = option.padd + "_text-gray-900 _text-md _p-2";
                item.innerHTML = option.innerText.trim();
                if (option.hasAttribute("selected") && !option.hasAttribute("disabled")) {
                    Select._select({
                        list: el.list,
                        container: el.container,
                        current: el.current,
                        input: el.input,
                        target: item,
                        option: option
                    }, index);
                }
                if (option.hasAttribute("disabled")) {
                    item.className += " _bg-gray-400";
                } else {
                    item.className += " _hover:bg-gray-900 _hover:text-gray-900 _hover:bg-opacity-10 _cursor-pointer";
                    item.addEventListener("click", e => {
                        Select._select({
                            list: el.list,
                            container: el.container,
                            current: el.current,
                            input: el.input,
                            target: item,
                            option: option,
                        }, index);
                        if (!el.current.multiple) {
                            Select._toggle({
                                container: el.container,
                                current: el.current,
                                search: el.search,
                                list: el.list
                            });
                        }
                        el.current.dispatchEvent(new CustomEvent('select', {
                            bubbles: true,
                            detail: {
                                item: item,
                                index: index,
                            }
                        }));
                    });
                }
                el.list.append(item);
            }
        }
        el.current.dispatchEvent(new CustomEvent('load', {
            bubbles: true,
            detail: {
                display: el.input,
                search: el.search,
            }
        }));
    }
}
Select._trigger = "x-select";
Select._el = null;
Select._style = {
    color: "#FFFFFF",
    background: "#60A5FA",
};
Select._template = (placeholder) => /*html*/ `
        <div tabindex="0" class="_w-full _bg-gray-50 _border _border-gray-300 _appearance-none _text-gray-900 _text-md _rounded-md _pr-10 _p-2 _focus:outline-1 _outline-blue-400 _cursor-pointer">
            <div class="_w-full _overflow-x-auto _no-scrollbar">
                <div contenteditable="false" placeholder="${placeholder||"&nbsp;"}" class="_w-max _min-w-full _flex _gap-2 _items-center"></div>
            </div>
        </div>
        <svg class="_block _w-5 _h-5 _text-gray-900 _pointer-events-none _absolute _right-2 _top-1/2 _-translate-y-1/2" fill="currentcolor" viewBox="0 0 48 48">
            <path d="M24 31.8 10.9 18.7 14.2 15.45 24 25.35 33.85 15.5 37.1 18.75Z" />
        </svg>
        <div x-wrap class="_fixed _items-center _justify-center _p-4 _inset-0 _bg-gray-900 _bg-opacity-40 _z-9999 _lg:z-10 _lg:absolute _lg:top-full _lg:inset-auto _lg:p-0 _lg:w-full _lg:rounded-lg _hidden">
            <button class="_block _absolute _top-2 _right-4 _text-white _rounded-md _focus:outline-1 _focus:outline-1-2 _outline-blue-400 _lg:hidden">
                <svg class="_block _w-10 _h-10 _pointer-events-none" fill="currentcolor" viewBox="0 0 48 48">
                    <path
                        d="M12.45 37.65 10.35 35.55 21.9 24 10.35 12.45 12.45 10.35 24 21.9 35.55 10.35 37.65 12.45 26.1 24 37.65 35.55 35.55 37.65 24 26.1Z"
                    />
                </svg>
            </button>
            <div class="_w-full _bg-white _rounded-lg _shadow-md _overflow-hidden _border _border-gray-200">
                <div class="_w-full _overflow-auto _max-h-100 _lg:max-h-60">
                    <input id="search" type="search" placeholder="Search" class="_appearance-none _sticky _top-0 _bg-white _border-b _border-gray-300 _text-gray-900 _text-md _block _w-full _p-2 _outline-none" />
                    <ul class="_w-full">
                    </ul>
                </div>
            </div>
        </div>
    `;