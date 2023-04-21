@extends('admin.admin_master')
@section('admin')


<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">{{ __("Roles And Permissions") }}</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title ">{{ __("Role Management And Permissions") }} </h4>
                        <div class="row  mt-3 justify-content-center">
                            <div class="col-md-6 col-sm-12 text-center">
                                <h4 class="text-center font-size-20 ">{{ __("Roles") }}</h4>
                                <form method="post" action="{{ route('append.role') }}" id="myForm">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="example-text-input" class="col-sm-4 col-form-label">{{ __("Role Name") }}:</label>
                                        <div class="form-group col-sm-8">
                                            <input name="role_name" class="form-control" type="text">
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-info waves-effect waves-light" value="{{ __('Add Role') }}">
                                </form>
                            </div>
                        </div>
                        <hr class="hr mt-3" />
                        <form method="post" action="{{ route('append.permissions') }}" id="myForm">
                            <div class="row justify-content-center mt-3 mt-sm-3 mt-lg-3 mt-md-3">
                                <div class="col-md-6 col-sm-12 text-center mt-3 mt-sm-0 mt-md-0 mt-xl-0">
                                    <h4 class="text-center font-size-20">{{ __("Permissions") }}</h4>
                                    <div class="form-group row">
                                        <label for="roles_data" class="col-sm-4 col-form-label ">{{ __("Role") }}:</label>
                                        <div class="col-sm-8">
                                            <select name="roles_data" id="roles_data" class="form-select">


                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row  mt-3">

                                <div class="alert alert-warning text-center" role="alert">
                                    {{ __("Please Check The privilages that you want to give to the role") }}
                                </div>
                            </div>

                            <div class="row mx-auto">

                                @csrf

                                <div class="col-md-6   ">

                                    <div class="form-check mb-2 ">
                                        <input class="form-check-input" type="checkbox" id="formCheck1" name="m_supp">
                                        <label class="form-check-label" for="formCheck1">
                                            {{ __("Manage Suppliers") }}
                                        </label>
                                    </div>
                                    <div class="form-check  mb-2">
                                        <input class="form-check-input" type="checkbox" id="formCheck2" name="m_cust">
                                        <label class="form-check-label" for="formCheck2">
                                            {{ __("Manage Customers") }}
                                        </label>
                                    </div>
                                    <div class="form-check  mb-2">
                                        <input class="form-check-input" type="checkbox" id="formCheck2" name="m_unit">
                                        <label class="form-check-label" for="formCheck2">
                                            {{ __("Manage Units") }}
                                        </label>
                                    </div>
                                    <div class="form-check  mb-2">
                                        <input class="form-check-input" type="checkbox" id="formCheck2" name="m_brand">
                                        <label class="form-check-label" for="formCheck2">
                                            {{ __("Manage Brands") }}
                                        </label>
                                    </div>
                                    <div class="form-check  mb-2">
                                        <input class="form-check-input" type="checkbox" id="formCheck2" name="m_categ">
                                        <label class="form-check-label" for="formCheck2">
                                            {{ __("Manage Categories") }}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6 ">


                                    <div>
                                        <div class="form-check    mb-2">
                                            <input class="form-check-input" type="checkbox" id="formCheckRight1" name="m_prod">
                                            <label class="form-check-label" for="formCheckRight1">
                                                {{ __("Manage Products") }}
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-check   mb-2">
                                            <input class="form-check-input" type="checkbox" id="formCheckRight2" name="m_purch">
                                            <label class="form-check-label" for="formCheckRight2">
                                                {{ __("Manage Purchases") }}
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-check   mb-2">
                                            <input class="form-check-input" type="checkbox" id="formCheckRight2" name="m_recei">
                                            <label class="form-check-label" for="formCheckRight2">
                                                {{ __("Manage Receipts") }}
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-check   mb-2">
                                            <input class="form-check-input" type="checkbox" id="formCheckRight2" name="m_inv">
                                            <label class="form-check-label" for="formCheckRight2">
                                                {{ __("Manage Invoices") }}
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="form-check   mb-2">
                                            <input class="form-check-input" type="checkbox" id="formCheckRight2" name="m_stock">
                                            <label class="form-check-label" for="formCheckRight2">
                                                {{ __("Manage Stock") }}
                                            </label>
                                        </div>
                                    </div>

                                </div>

                                <div class="row col-6 mx-auto mt-3 mt-md-3">
                                    <input type="submit" class="btn btn-info waves-effect waves-light" value="{{ __('Save') }}">
                                </div>

                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->



</div> <!-- container-fluid -->
</div>
<script>
    window.addEventListener('load', () => {
        getRoles();
        getPermissions();
    });

    async function getRoles() {
        try {

            const response = await fetch('{{route("get-all-roles")}}');
            const data = await response.json();

            let html = '<option value="">{{ __("Select A Role") }}</option>';
            data.forEach(value => {

                html += `<option value="${value.name}">${value.name}</option>`;
            });
            document.getElementById('roles_data').innerHTML = html;
        } catch (error) {
            console.log(error);
        }

    }
    async function getPermissions(rolename) {
        try {
            const response = await fetch(`{{route('get-permission')}}?rolename=${rolename}`);
            const data = await response.json();
            return data;

        } catch (error) {
            console.log(error);
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('#roles_data').addEventListener('change', async function(event) {
            resetcheckbox();
            let roleName = this.value;
            let data = await getPermissions(roleName);

            data.forEach(function(permission) {

                let checkbox = document.querySelector(`[name="${permission.name}"]`);

                if (checkbox) {
                    checkbox.checked = true;
                }
            });
            /*       console.log(Object.keys(data.PromiseResult)); */

        });
    });

    function resetcheckbox() {
        let checkboxs = document.querySelectorAll('.form-check-input');
        checkboxs.forEach(function(checkbox) {
            checkbox.checked = false;
        });

    }
</script>

@endsection