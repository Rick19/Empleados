@php
    $container = 'container-xxl';
    $containerNav = 'container-xxl';
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Editar empleado')

@section('content')
    <section id="edit-puesto">
        <div class="col-xxl">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Editar empleado</h5> <small class="text-muted float-end"><span
                                class="text-danger">* </span>Todos los elementos son
                        necesarios</small>
                </div>
                <div class="card-body">
                    @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {{Session::get('success')}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                    @endif
                    <form action="{{ route('empleados.update', $empleado->id) }}" method="POST"
                          id="form-empleado-update">
                        @csrf
                        @method('PATCH')
                        <div class="row mb-3">
                            <!-- Nombre -->
                            <div class="row mb-3 pe-0">
                                <div class="col-md-4 col-12 pe-0">
                                    <label class="form-label" for="nombre">Nombre/s <span
                                                class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-user"></i></span>
                                        <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                               id="nombre" name="nombre" value="{{$empleado->nombre}}"
                                               placeholder="Jefferson" aria-label="Sonia" aria-describedby="nombre"
                                               required/>
                                    </div>
                                    @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- Apellido Paterno -->
                                <div class="col-md-4 col-12 pe-0">
                                    <label class="form-label" for="apellido-paterno">Apellido paterno <span
                                                class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                    <span id="apellido-paterno2" class="input-group-text"><i
                                                class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" id="apellido-paterno"
                                               name="apellido_paterno" value="{{$empleado->apellido_paterno}}"
                                               placeholder="Gutierritoz" aria-label="apellido-paterno"
                                               aria-describedby="apellido-paterno" required/>
                                    </div>
                                </div>
                                <!-- Apellido Materno -->
                                <div class="col-md-4 col-12 pe-0">
                                    <label class="form-label" for="apellido-materno">Apellido materno <span
                                                class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                    <span id="apellido-materno2" class="input-group-text"><i
                                                class="bx bx-user"></i></span>
                                        <input type="text" class="form-control" id="apellido-materno"
                                               name="apellido_materno" value="{{$empleado->apellido_materno}}"
                                               placeholder="Pérez" aria-label="Pérez"
                                               aria-describedby="apellido-materno2" required/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 pe-0">
                            <!-- Email -->
                            <div class="col-md-4 col-12 pe-0">
                                <label class="form-label" for="correo">Email <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge @error('correo') is-invalid @enderror">
                                    <span class="input-group-text">
                                        <i class="bx bx-envelope"></i></span>
                                    <input type="email" id="correo" value="{{$empleado->correo}}"
                                           class="form-control @error('correo') is-invalid @enderror" name="correo"
                                           placeholder="jefferson@example.com" aria-label="email"
                                           aria-describedby="email2" required/>
                                </div>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Compañía -->
                            <div class="col-md-8 col-12 pe-0">
                                <label class="form-label" for="company">Compañía <span
                                            class="text-danger">*</span></label>
                                <div class="input-group input-group-merge @error('company') is-invalid @enderror">
                                    <span id="company2" class="input-group-text"><i class="bx bx-buildings"></i></span>
                                    <select id="company"
                                            class="form-control form-select @error('company') is-invalid @enderror"
                                            name="company"
                                            required>
                                        <option hidden selected>Selecciona la compañía</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}" {{$empleado->company->id == $company->id ? 'selected' : ''}}>{{ $company->alias }}
                                                [{{ $company->name }}]
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('company')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3 pe-0">
                            <!-- Fecha de Ingreso -->
                            <div class="col-md-4 col-12 pe-0">
                                <label class="form-label" for="fecha-ingreso">Fecha de Ingreso <span
                                            class="text-danger">*</span></label>
                                <div class="input-group input-group-merge @error('fecha_ingreso') is-invalid @enderror">
                                    <input class="form-control @error('fecha_ingreso') is-invalid @enderror" type="date"
                                           id="fecha-ingreso" value="{{$empleado->fecha_ingreso}}"
                                           name="fecha_ingreso" required/>
                                </div>
                                @error('fecha_ingreso')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Puesto -->
                            <div class="col-md-8 col-12 pe-0">
                                <label class="form-label" for="puesto">Puesto <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge @error('puesto') is-invalid @enderror">
                                    <span id="puesto2" class="input-group-text"><i class="bx bx-phone"></i></span>
                                    <select id="puesto" name="puesto"
                                            class="form-control form-select @error('puesto') is-invalid @enderror"
                                            required>
                                        <option hidden selected>Selecciona el puesto</option>
                                        @foreach($puestos as $puesto)
                                            <option value="{{ $puesto->id }}"
                                                    {{$empleado->puesto_id== $puesto->id ? 'selected' : ''}}>{{ $puesto->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('puesto')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer pt-0">
                    <hr>
                    <div class="d-flex justify-content-end mx-auto gap-3">
                        <button type="submit" class="btn btn-primary" form="form-empleado-update">
                            <i class="bx bxs-save me-2"></i>Actualizar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page-script')
    <script>
        // Token csrf
        let _t = $('meta[name="csrf-token"]').attr('content');

        $(document).ready(function () {

        });
    </script>
@endsection