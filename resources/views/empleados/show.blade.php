@extends('layouts/contentNavbarLayout')

@section('title', $empleado->nombreCompleto )

@section('page-script')
    <script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>
@endsection

@section('content')
    <h5 class="fw-bold">
        <span class="text-muted fw-light">
            <a href="{{route('empleados.index')}}"><i class="bx bx-arrow-back me-1"></i>Empleados</a> /</span> Detalle
        del empleado
    </h5>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between ">
                        <h5>Detalles del empleado</h5>
                        <h5>{{$empleado->nombreCompleto}}</h5>
                    </div>
                </div>
                <hr class="my-0">
                <div class="card-body">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-container">
                                    <ul class="list-unstyled">
                                        <li class="mb-3">
                                            <span class="fw-bold me-2">Nombre:</span>
                                            <span>{{ $empleado->nombre }}</span>
                                        </li>
                                        <li class="mb-3">
                                            <span class="fw-bold me-2">Apellido Paterno:</span>
                                            <span>{{ $empleado->apellido_paterno }}</span>
                                        </li>
                                        <li class="mb-3">
                                            <span class="fw-bold me-2">Apellido Materno:</span>
                                            <span>{{ $empleado->apellido_materno }}</span>
                                        </li>
                                        <li class="mb-3">
                                            <span class="fw-bold me-2">Correo electrónico:</span>
                                            <span>{{ $empleado->correo }}</span>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-container">
                                    <ul class="list-unstyled">
                                        <li class="mb-3">
                                            <span class="fw-bold me-2">Compañía</span>
                                            <span>
                                                @if($empleado->company)
                                                    {{$empleado->company->name}}
                                                @else
                                                    Compañía eliminada
                                                @endif
                                            </span>
                                        </li>
                                        <li class="mb-3">
                                            <span class="fw-bold me-2">Puesto</span>
                                            <span>
                                            @if($empleado->puesto)
                                                    {{$empleado->puesto->name}}
                                                @else
                                                    Puesto eliminado
                                                @endif
                                            </span>
                                        </li>
                                        <li class="mb-3">
                                            <span class="fw-bold me-2">Fecha de ingreso</span>
                                            <span>{{ $empleado->fecha_ingreso }}</span>
                                        </li>
                                        <li class="mb-3">
                                            <span class="fw-bold me-2">Status:</span>
                                            <span class="badge bg-label-{{$empleado->deleted_at ? 'danger':'success'}}">
                                                {{$empleado->deleted_at ? 'Eliminado':'Activo'}}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-0">
                <div class="card-footer py-2">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <span class="fw-bold me-2">Fecha de registro:</span>
                            <span>{{$empleado->created_at}}</span>
                        </div>
                        <div class="col-md-6 col-12 ps-0">
                            <span class="fw-bold me-2">Fecha de actualización:</span>
                            <span>{{$empleado->updated_at}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
