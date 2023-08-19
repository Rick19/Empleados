@php
    $container = 'container-xxl';
    $containerNav = 'container-xxl';
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Listado de compañías')

@section('content')
    {{--  Si no hay registros para compañías, mostraremos un mensaje al usuario indicando dicho evento  --}}
    @if($companies->isEmpty())
        <section class="h-100 d-flex align-items-center justify-content-center">
            <div class="text-center">
                <p>No hay <strong>compañías</strong> resgistradas aún 😔, Intenta agregar un registro! 😃</p>
                <img class="my-4" src="{{ asset('assets/img/illustrations/empty_street.svg') }}" alt="sin compañias">
                <div class="d-grid gap-2 col-lg-6 mx-auto">
                    <button onclick="location.href='{{route('companies.create')}}'" class="btn btn-primary"
                            type="button">
                        <span class="tf-icons bx bx-plus"></span>
                        Agregar compañía
                    </button>
                </div>
            </div>
        </section>
    @else
        {{-- En caso contrario, mostraremos el listado de compañías --}}
        <section id="list-companies">
            <div class="row">
                <h3>Listado de compañías</h3>
                <div class="col-md-12 mb-4">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="Búscar compañía..."
                               aria-label="Búscar compañía..."
                               id="company-search"
                               aria-describedby="basic-addon-search31">
                    </div>
                </div>
                {{-- Iteramos sobre cada compañía --}}
                @foreach($companies as $company)
                    <div class="col-md-4 col-sm-4 col-12 text-center company-card {{$company->deleted_at !== null ? 'text-muted': ''}}"
                         data-company="{{$company->id}}">
                        <div class="card">
                            <div class="card-header">
                                <span class="display-4 mb-0 company-alias">
                                    {{$company->alias}}
                                </span>
                            </div>
                            <div class="card-body">
                                <p class="company-name">{{$company->name}}</p>
                            </div>
                            <div class="card-footer pt-0">
                                <div class="d-flex btn-group" role="group">
                                    @if($company->deleted_at)
                                        <button type="button" class="btn btn-outline-warning reactivate-company-btn"
                                                data-company="{{$company->id}}"
                                                data-name="{{ $company->name }}"
                                                data-alias="{{ $company->alias }}"
                                                onclick="reactivateCompany({{$company->id}})">
                                            <i class="tf-icons bx bx-refresh bx-xs me-2"></i>Restaurar
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-outline-secondary edit-company-btn"
                                                data-company="{{$company->id}}"
                                                data-name="{{ $company->name }}"
                                                data-alias="{{ $company->alias }}"
                                                data-bs-toggle="modal" data-bs-target="#editCompanyModal"><i
                                                    class="tf-icons bx bxs-edit-alt bx-xs me-2"></i>Editar
                                        </button>
                                        <button type="button" class="btn btn-outline-danger delete-company-btn"
                                                data-company="{{$company->id}}"
                                                data-name="{{ $company->name }}"
                                                data-alias="{{ $company->alias }}"
                                                onclick="deleteCompany({{$company->id}})"><i
                                                    class="tf-icons bx bxs-trash-alt bx-xs me-2"></i>Remover
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        @include('companies._modals.edit-company-modal')

    @endif
@endsection

@section('page-script')
    <script>
        // Token csrf
        let _t = $('meta[name="csrf-token"]').attr('content');

        $(document).ready(function () {
            // Detectamos cambios en el campo de búsqueda
            $("#company-search").on("input", function () {
                // Convertimos el término de búsqueda a minúsculas
                let searchTerm = $(this).val().toLowerCase();

                // Iteramos sobre cada tarjeta de compañía
                $(".company-card").each(function () {
                    // Obtenemos el contenido del nombre y alias de la compañía
                    let companyName = $(this).find(".card-body p").text().toLowerCase();
                    let companyAlias = $(this).find(".card-header h1").text().toLowerCase();

                    // Comparamos el término de búsqueda con nombre o alias
                    if (companyName.includes(searchTerm) || companyAlias.includes(searchTerm)) {
                        $(this).show(); // Mostramos la tarjeta si hay coincidencia
                    } else {
                        $(this).hide(); // Ocultamos la tarjeta si no hay coincidencia
                    }
                });
            });

            // Al abrir el modal de edición
            $('#editCompanyModal').on('show.bs.modal', function (event) {
                let button = $(event.relatedTarget); // Botón que abrió el modal
                // Se obtienen los datos de la compañía
                let company = button.data('company');
                let companyName = button.data('name');
                let companyAlias = button.data('alias');

                // Asignamos los datos a sus respectivos inputs
                $(':hidden#company').val(company);
                $('#name').val(companyName);
                $('#alias').val(companyAlias);
            });

            //  Formulario para actualizar la compañía por ajax
            $('#form-company-update').on('submit', function (e) {
                e.preventDefault()
                let company = $(':hidden#company').val();
                let name = $('#name').val();
                let alias = $('#alias').val();

                $.ajax({
                    url: '/companies/' + company,
                    type: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': _t
                    },
                    data: {
                        name: name,
                        alias: alias
                    },
                    success: function (data) {
                        showToast("Éxito", data.message, 'success');
                        // Actualizar la tarjeta con los nuevos datos
                        let card = $('.company-card[data-company="' + company + '"]');
                        card.find('.company-alias').text(alias);
                        card.find('.company-name').text(name);
                        card.find('.edit-company-btn').data('alias', alias)
                        card.find('.edit-company-btn').data('name', name)
                        $('#editCompanyModal').modal('hide'); // Cerrar el modal
                    }
                });
            })
        });

        // Función para eliminar una compañía
        function deleteCompany(company) {
            // Confirmar antes de eliminar
            if (confirm('¿Estás seguro de que deseas eliminar esta compañía?')) {
                $.ajax({
                    url: '/companies/' + company,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': _t
                    },
                    success: function (data) {
                        showToast("Éxito", data.message, 'success');

                        // Agregar clase y cambiar botones si la compañía fue eliminada
                        const companyCard = $('.company-card[data-company="' + company + '"]');
                        companyCard.addClass('text-muted'); // Agregar clase de estilo
                        companyCard.find('.edit-company-btn').remove(); // Quitar botón de editar
                        companyCard.find('.delete-company-btn').remove(); // Quitar botón de eliminar
                        companyCard.find('.reactivate-company-btn').remove(); // Quitar botón de restaurar
                        companyCard.find('.d-flex.btn-group').prepend(`
            <button type="button" class="btn btn-outline-warning reactivate-company-btn"
                data-company="${company}"
                data-name="${companyCard.data('name')}"
                data-alias="${companyCard.data('alias')}"
                onclick="reactivateCompany(${companyCard.data('company')})"><i class="tf-icons bx bx-refresh bx-xs
                    me-2"></i>Restaurar
            </button>
        `);
                    },
                    error: function (error) {
                        showToast("Error", error.responseJSON.message, 'danger');
                    }
                });
            }
        }

        // Función para reactivar una compañía
        function reactivateCompany(company) {
            $.ajax({
                url: '/companies/reactivate/' + company,
                type: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': _t
                },
                success: function (data) {
                    showToast("Éxito", data.message, 'success');

                    // Remover clase y cambiar botones si la compañía fue reactivada
                    const companyCard = $('.company-card[data-company="' + company + '"]');
                    companyCard.removeClass('text-muted', ' text-muted'); // Remover clase de estilo
                    companyCard.find('.reactivate-company-btn').remove(); // Quitar botón de restaurar
                    companyCard.find('.d-flex.btn-group').append(`
                <button type="button" class="btn btn-outline-secondary edit-company-btn"
                        data-company="${data.company.id}"
                        data-name="${data.company.name}"
                        data-alias="${data.company.alias}"
                        data-bs-toggle="modal" data-bs-target="#editCompanyModal"><i
                            class="tf-icons bx bxs-edit-alt bx-xs me-2"></i>Editar
                </button>
                <button type="button" class="btn btn-outline-danger delete-company-btn"
                        data-company="${data.company.id}"
                        data-name="${data.company.name}"
                        data-alias="${data.company.alias}"
                        onclick="deleteCompany(${data.company.id})"><i
                            class="tf-icons bx bxs-trash-alt bx-xs me-2"></i>Remover
                </button>
            `);
                },
                error: function (error) {
                    showToast("Error", error.responseJSON.message, 'danger');
                }
            });
        }
    </script>
    <script src="{{asset('assets/js/toast.js')}}"></script>
@endsection
