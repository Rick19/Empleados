@php
    $container = 'container-xxl';
    $containerNav = 'container-xxl';
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Crear compañía')

@section('content')
    <section id="create-companie">
        <div class="col-xxl">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Agregar compañía</h5> <small class="text-muted float-end"><span
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

                    <form action="{{route('companies.store')}}" method="POST" id="form-company-store">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="name">Nombre <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="name2" class="input-group-text"><i
                                                class="bx bx-buildings"></i></span>
                                    <input type="text" class="form-control" id="name" name="name"
                                           placeholder="Nombre de la compañía" aria-label="Nombre de la compañía"
                                           aria-describedby="Nombre de la compañía">
                                </div>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div id="defaultFormControlHelp" class="form-text">
                                    Ejemplo: Hewlett-Packard, Pepsico
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="alias">Alias <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="alias2" class="input-group-text"><i
                                                class="bx bxs-user-detail"></i></span>
                                    <input type="text" id="alias" class="form-control" name="alias"
                                           placeholder="Asigna un alias a la empresa" aria-label="ACME Inc."
                                           aria-describedby="Alias de la compañía">
                                </div>
                                @error('alias')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div id="defaultFormControlHelp" class="form-text">
                                    Ejemplo: HP, Pepsi, Bimbo
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer pt-0">
                    <hr>
                    <div class="d-flex justify-content-end mx-auto gap-3">
                        <button type="submit" class="btn btn-primary" form="form-company-store">
                            <i class="bx bxs-save me-2"></i>Registrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
