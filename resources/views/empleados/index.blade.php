@php
    $container = 'container-xxl';
    $containerNav = 'container-xxl';
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Listado de Empleados')

@section('content')
    {{--  Si no hay registros para compañías, mostraremos un mensaje al usuario indicando dicho evento  --}}
    @if($empleados->isEmpty())
        <section class="h-100 d-flex align-items-center justify-content-center">
            <div class="text-center">
                <p>No hay <strong>empleados</strong> resgistrados aún 😔, Intenta agregar uno! 😃</p>
                <img class="my-4" src="{{ asset('assets/img/illustrations/empty_street.svg') }}" alt="sin empleados">
                <div class="d-grid gap-2 col-lg-6 mx-auto">
                    <button onclick="location.href='{{route('empleados.create')}}'" class="btn btn-primary"
                            type="button">
                        <span class="tf-icons bx bx-plus"></span>
                        Agregar empleado
                    </button>
                </div>
            </div>
        </section>
    @else

        <div class="card h-100">
            <h5 class="card-header">Listado de Empleados</h5>
            <div class="table-responsive text-nowrap h-100">
                <table class="table table-striped table-sm">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Correo</th>
                        <th>Puesto</th>
                        <th>Compañía</th>
                        <th>status</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($empleados as $empleado)
                        <tr>
                            <td><a href="{{route('empleados.show', $empleado->id)}}">{{$empleado->nombre}}</a></td>
                            <td>{{$empleado->apellido_paterno}}</td>
                            <td>{{$empleado->apellido_materno}}</td>
                            <td><i class="bx bx-envelope me-2"></i>{{$empleado->correo}}</td>
                            <td>{{ $empleado->puesto ? $empleado->puesto->name : 'Puesto eliminado' }}</td>
                            <td>{{ $empleado->company ? $empleado->company->name : 'Compañía eliminada' }}</td>
                            <td>
                                <span class="badge bg-label-{{$empleado->deleted_at ? 'danger':'success'}}">
                                                {{$empleado->deleted_at ? 'Eliminado':'Activo'}}
                                            </span>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu">
                                        @if($empleado->deleted_at)
                                            <form id="reactivate-form-{{$empleado->id}}"
                                                  action="{{route('empleados.restore', $empleado->id)}}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" class="dropdown-item text-warning reactivate-btn">
                                                    <i class="bx bx-refresh me-1"></i> Reactivar
                                                </button>
                                            </form>
                                        @else
                                            <a class="dropdown-item text-secondary"
                                               href="{{route('empleados.edit', $empleado->id)}}">
                                                <i class="bx bx-edit me-1"></i> Editar
                                            </a>
                                            <form id="delete-form-{{$empleado->id}}"
                                                  action="{{route('empleados.destroy', $empleado->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="dropdown-item text-danger delete-btn">
                                                    <i class="bx bx-trash me-1"></i> Eliminar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection

@section('page-script')
    <script src="{{asset('assets/js/toast.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('.reactivate-btn').click(function () {
                if (confirm('¿Estás seguro de que deseas reactivar este empleado?')) {
                    $(this).closest('form').submit();
                }
            });

            $('.delete-btn').click(function () {
                if (confirm('¿Estás seguro de que deseas eliminar este empleado?')) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
@endsection
