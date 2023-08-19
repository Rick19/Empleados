@php
    $container = 'container-xxl';
    $containerNav = 'container-xxl';
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Crear puesto')

@section('content')
    <section id="create-puesto">
        <div class="col-xxl">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Agregar puesto</h5> <small class="text-muted float-end"><span
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

                    <form action="{{route('puestos.store')}}" method="POST" id="form-puesto-store">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="name">Nombre <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span id="name2" class="input-group-text"><i
                                                class="bx bx-briefcase"></i></span>
                                    <input type="text" class="form-control" id="name" name="name"
                                           placeholder="Nombre del puesto" aria-label="Nombre del puesto"
                                           aria-describedby="Nombre del puesto">
                                </div>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Ejemplo: Reclutador JR
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer pt-0">
                    <hr>
                    <div class="d-flex justify-content-end mx-auto gap-3">
                        <button type="submit" class="btn btn-primary" form="form-puesto-store">
                            <i class="bx bxs-save me-2"></i>Registrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
