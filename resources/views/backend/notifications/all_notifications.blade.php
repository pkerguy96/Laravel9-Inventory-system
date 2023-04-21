@extends('admin.admin_master')
@section('admin')


    <div class="page-content">
        @if ($notifications->count() > 0)
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class=" col-md-8">
                        @foreach ($notifications as $notification)
                            <div class="card">
                                <div class="card-header border-primary d-flex justify-content-between">
                                    <h5 class="my-0 text-primary"><i
                                            class="mdi mdi-bullseye-arrow me-3"></i>{{ $notification->type }}</h5>
                                    <button type="button" class="btn-close " data-attr-NotifyID="{{ $notification->id }}"
                                        onclick="DeleteNotificationDOM(this,event)"></button>
                                </div>
                                <div class="card-body">
                                    <div class="card-title">{{ $notification->message }}</div>
                                    <p class="card-text">{{ __('Only') }} {{ $notification['products']['product_qte'] }}
                                        {{ __('Are Left') }} </p>
                                    <p class="mb-0"><i
                                            class="mdi mdi-clock-outline"></i>{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        @endforeach


                    </div>

                    <div class="row justify-content-center" style="margin-top: 10%;">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center">
                                @if ($notifications->onFirstPage())
                                    <li class="page-item disabled"><a class="page-link"
                                            href="#">{{ __('Previous') }}</a></li>
                                @else
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $notifications->previousPageUrl() }}">{{ __('Previous') }}</a></li>
                                @endif
                                {{ $notifications->links('vendor.pagination.bootstrap-4') }}
                                @if ($notifications->hasMorePages())
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $notifications->nextPageUrl() }}">{{ __('Next') }}</a></li>
                                @else
                                    <li class="page-item disabled"><a class="page-link"
                                            href="#">{{ __('Next') }}</a></li>
                                @endif
                            </ul>
                        </nav>

                    </div>


                </div>
            </div>
        @else
            <div class="container-fluid">
                <div class="card mt-5">
                    <div class="card-body ">

                        <p class="card-text text-center">{{ __('No New Notification Available') }}</p>

                    </div>
                </div>
            </div>
        @endif
        <script>
            function DeleteNotificationDOM(button, event) {
                const btn = button.parentNode.parentNode;
                const Notificationid = +button.getAttribute('data-attr-NotifyID');
                if (!Notificationid) {
                    return;
                } else {
                    const url = `{{ route('delete-notification-fromdb') }}?notificationid=${Notificationid}`;
                    DeleteNotificationDb(url);



                }
                btn.remove();
            }
        </script>
        <script>
            async function DeleteNotificationDb(url) {
                try {
                    const response = await fetch(url);
                    const data = await response.json();
                    $.notify(data.message, "info");
                } catch (error) {
                    console.log(error);
                }

            }
        </script>
    </div>
@endsection
