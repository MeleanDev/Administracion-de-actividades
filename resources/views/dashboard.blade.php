@extends('adminlte.app')

{{-- Customize layout sections --}}

@section('subtitle', 'Panel Principal')


{{-- Content body: main page content --}}

@section('content_body')
    <div class="container">
        <div class="h1 text-center">
            <p style="font-family: Bold">Panel Principal</p>
        </div>
        <div class="Bienvenida Card">
            <div class="col-lg-10 mb-4 order-0 mx-auto">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                <h5 class="card-title text-black">Bienvenido {{auth()->user()->name}}!! 😎🎉</h5>
                                <p class="mb-2">
                                    <br>Al sistema X. <br><br>Sistema desarrollado por MeleanDev.
                                </p>
                        
                                <a href="{{ config('app.company_url', '') }}" target="_blank" class="btn btn-sm btn-primary">Contactar con el Desarrollador</a>
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img
                                src="{{ asset("img/panelcard.png") }}"
                                height="160"
                                alt="img del sistema"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('css')

@endpush

@push('js')
@endpush