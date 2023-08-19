@php
    $container = 'container-xxl';
    $containerNav = 'container-xxl';
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Listado de puestos')

@section('content')
    {{--  Si no hay registros para puestos, mostraremos un mensaje al usuario indicando dicho evento  --}}
    @if($puestos->isEmpty())
        <section class="h-100 d-flex align-items-center justify-content-center">
            <div class="text-center">
                <p>No hay <strong>puestos</strong> resgistrados aún 😔, Intenta agregar uno! 😃</p>
                <img class="my-4" src="{{ asset('assets/img/illustrations/empty_street.svg') }}" alt="sin puestos">
                <div class="d-grid gap-2 col-lg-6 mx-auto">
                    <button onclick="location.href='{{route('puestos.create')}}'" class="btn btn-primary"
                            type="button">
                        <span class="tf-icons bx bx-plus"></span>
                        Agregar puesto
                    </button>
                </div>
            </div>
        </section>
    @else
        {{-- En caso contrario, mostraremos el listado de puestos --}}
        <section id="list-puestos">
            <div class="row">
                <h3>Listado de puestos</h3>
                <div class="col-md-12 mb-4">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="Búscar puesto..."
                               aria-label="Búscar puesto..."
                               id="puesto-search"
                               aria-describedby="basic-addon-search31">
                    </div>
                </div>
                {{-- Iteramos sobre cada puesto --}}
                @foreach($puestos as $puesto)
                    <div class="col-md-4 col-sm-4 col-12 text-center puesto-card {{$puesto->deleted_at !== null ? 'text-muted': ''}}"
                         data-puesto="{{$puesto->id}}">
                        <div class="card">
                            <div class="card-header">
                                <span class="display-4 mb-0 puesto-name">
                                    {{$puesto->name}}
                                </span>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex btn-group" role="group">
                                    @if($puesto->deleted_at)
                                        <button type="button" class="btn btn-outline-warning reactivate-puesto-btn"
                                                data-puesto="{{$puesto->id}}"
                                                data-name="{{ $puesto->name }}"
                                                onclick="reactivatePuesto({{$puesto->id}})">
                                            <i class="tf-icons bx bx-refresh bx-xs me-2"></i>Restaurar
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-outline-secondary edit-puesto-btn"
                                                data-puesto="{{$puesto->id}}"
                                                data-name="{{ $puesto->name }}"
                                                data-bs-toggle="modal" data-bs-target="#editPuestoModal"><i
                                                    class="tf-icons bx bxs-edit-alt bx-xs me-2"></i>Editar
                                        </button>
                                        <button type="button" class="btn btn-outline-danger delete-puesto-btn"
                                                data-puesto="{{$puesto->id}}"
                                                data-name="{{ $puesto->name }}"
                                                onclick="deletePuesto({{$puesto->id}})"><i
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
        @include('puestos._modals.edit-puesto-modal')

    @endif
@endsection

@section('page-script')
    <script>
        // Token csrf
        let _t = $('meta[name="csrf-token"]').attr('content');

        $(document).ready(function () {
            // Detectamos cambios en el campo de búsqueda
            $("#puesto-search").on("input", function () {
                // Convertimos el término de búsqueda a minúsculas
                let searchTerm = $(this).val().toLowerCase();

                // Iteramos sobre cada tarjeta de puesto
                $(".puesto-card").each(function () {
                    // Obtenemos el contenido del nombre del puesto
                    let puestoName = $(this).find(".card-header span").text().toLowerCase();

                    // Comparamos el término de búsqueda con nombre
                    if (puestoName.includes(searchTerm)) {
                        $(this).show(); // Mostramos la tarjeta si hay coincidencia
                    } else {
                        $(this).hide(); // Ocultamos la tarjeta si no hay coincidencia
                    }
                });
            });

            // Al abrir el modal de edición
            $('#editPuestoModal').on('show.bs.modal', function (event) {
                let button = $(event.relatedTarget); // Botón que abrió el modal
                // Se obtienen los datos del puesto
                let puesto = button.data('puesto');
                let puestoName = button.data('name');

                // Asignamos los datos a sus respectivos inputs
                $(':hidden#puesto').val(puesto);
                $('#name').val(puestoName);
            });

            //  Formulario para actualizar el puesto por ajax
            $('#form-puesto-update').on('submit', function (e) {
                e.preventDefault()
                let puesto = $(':hidden#puesto').val();
                let name = $('#name').val();

                $.ajax({
                    url: '/puestos/' + puesto,
                    type: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': _t
                    },
                    data: {
                        name: name
                    },
                    success: function (data) {
                        showToast("Éxito", data.message, 'success');
                        // Actualizar la tarjeta con los nuevos datos
                        let card = $('.puesto-card[data-puesto="' + puesto + '"]');
                        card.find('.puesto-name').text(name);
                        card.find('.edit-puesto-btn').data('name', name)
                        $('#editPuestoModal').modal('hide'); // Cerrar el modal
                    }
                });
            })
        });

        // Función para eliminar un puesto
        function deletePuesto(puesto) {
            // Confirmar antes de eliminar
            if (confirm('¿Estás seguro de que deseas eliminar esta puesto?')) {
                $.ajax({
                    url: '/puestos/' + puesto,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': _t
                    },
                    success: function (data) {
                        showToast("Éxito", data.message, 'success');

                        // Agregar clase y cambiar botones si la puesto fue eliminada
                        const puestoCard = $('.puesto-card[data-puesto="' + puesto + '"]');
                        puestoCard.addClass('text-muted'); // Agregar clase de estilo
                        puestoCard.find('.edit-puesto-btn').remove(); // Quitar botón de editar
                        puestoCard.find('.delete-puesto-btn').remove(); // Quitar botón de eliminar
                        puestoCard.find('.reactivate-puesto-btn').remove(); // Quitar botón de restaurar
                        puestoCard.find('.d-flex.btn-group').prepend(`
            <button type="button" class="btn btn-outline-warning reactivate-puesto-btn"
                data-puesto="${puesto}"
                data-name="${puestoCard.data('name')}"
                onclick="reactivatePuesto(${puestoCard.data('puesto')})"><i class="tf-icons bx bx-refresh bx-xs
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

        // Función para reactivar un puesto
        function reactivatePuesto(puesto) {
            $.ajax({
                url: '/puestos/reactivate/' + puesto,
                type: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': _t
                },
                success: function (data) {
                    showToast("Éxito", data.message, 'success');

                    // Remover clase y cambiar botones si el puesto fue reactivada
                    const puestoCard = $('.puesto-card[data-puesto="' + puesto + '"]');
                    puestoCard.removeClass('text-muted', ' text-muted'); // Remover clase de estilo
                    puestoCard.find('.reactivate-puesto-btn').remove(); // Quitar botón de restaurar
                    puestoCard.find('.d-flex.btn-group').append(`
                <button type="button" class="btn btn-outline-secondary edit-puesto-btn"
                        data-puesto="${data.puesto.id}"
                        data-name="${data.puesto.name}"
                        data-bs-toggle="modal" data-bs-target="#editpuestoModal"><i
                            class="tf-icons bx bxs-edit-alt bx-xs me-2"></i>Editar
                </button>
                <button type="button" class="btn btn-outline-danger delete-puesto-btn"
                        data-puesto="${data.puesto.id}"
                        data-name="${data.puesto.name}"
                        onclick="deletePuesto(${data.puesto.id})"><i
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
