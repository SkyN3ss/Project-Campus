@extends('layouts.dashboard')
@section('title', 'Equipo: '.$product->name)
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-10">
      <h2>Equipo {{ $product->name }}</h2>
      <ol class="breadcrumb">
         <li>
            <a href="{{ route('home') }}">Inicio</a>
         </li>
         <li>
            <a href="{{ route('products.index') }}">Equipos</a>
         </li>
         <li class="active">
            <a href="#">
                <strong>Editar</strong>
            </a>
         </li>
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeIn">
   <div class="row">
      <div class="col-lg-12">
         <div class="ibox float-e-margins">
            <div class="ibox-title">
               <h5>Requeridos (*)</h5>
            </div>
            <div class="ibox-content">
               {{ Form::model($product, ['route' => ['products.update', $product->id], 'method' => 'PUT']) }}
               <div class="ibox-content">
                  <div class="row">
                     <div class="col-sm-12 b-r">
                        <div class="form-group">
                           <label>Nombre: (*)</label> 
                           {{ Form::text('name', $product->name, ['class' => 'form-control']) }}
                           @if ($errors->has('name'))
                             <span class="error-validate">
                                <strong>{{ $errors->first('name') }}</strong>
                             </span>
                           @endif
                        </div>
                        <div class="form-group">
                            <label>Empresa: (*)</label> 
                            {!! Form::select('id_client', json_decode($clients->pluck('name', 'id'), true), $product->client->id, ['class' => 'form-control select2-search', 'id' => 'name']) !!}
                            @if ($errors->has('id_client'))
                              <span class="error-validate">
                                 <strong>{{ $errors->first('id_client') }}</strong>
                              </span>
                            @endif
                         </div>
                         {{ Form::button('Nueva empresa', ['class' => 'btn btn-sm btn-primary', 'data-toggle' => 'modal', 'data-target' => '#myModal']) }}
                        <div class="form-group">
                            <label>Fabricante: (*)</label> 
                            {!! Form::select('id_fabricator', json_decode($fabricators->pluck('name', 'id'), true), $product->fabricator->id, ['class' => 'form-control select2-search', 'id' => 'name']) !!}
                            @if ($errors->has('id_fabricator'))
                              <span class="error-validate">
                                 <strong>{{ $errors->first('id_fabricator') }}</strong>
                              </span>
                            @endif
                         </div>
                         {{ Form::button('Nuevo fabricante', ['class' => 'btn btn-sm btn-primary', 'data-toggle' => 'modal', 'data-target' => '#ModalFabricator']) }}
                        <div class="form-group">
                            <label>Modelo: (*)</label> 
                            {{ Form::text('model', $product->model, ['class' => 'form-control']) }}
                            @if ($errors->has('model'))
                              <span class="error-validate">
                                 <strong>{{ $errors->first('model') }}</strong>
                              </span>
                            @endif
                         </div>
                         <div class="form-group">
                            <label>Nro Serial: (*)</label> 
                            {{ Form::text('serial_number', $product->serial_number, ['class' => 'form-control']) }}
                            @if ($errors->has('serial_number'))
                              <span class="error-validate">
                                 <strong>{{ $errors->first('serial_number') }}</strong>
                              </span>
                            @endif
                         </div>
                         <div class="form-group">
                            <label>Cod Interno: (*)</label> 
                            {{ Form::text('internal_code', $product->internal_code, ['class' => 'form-control']) }}
                            @if ($errors->has('internal_code'))
                              <span class="error-validate">
                                 <strong>{{ $errors->first('internal_code') }}</strong>
                              </span>
                            @endif
                         </div>
                         <div class="form-group">
                            <label>Magnitud: (*)</label> 
                            {{ Form::text('magnitude', $product->magnitude, ['class' => 'form-control']) }}
                            @if ($errors->has('magnitude'))
                              <span class="error-validate">
                                 <strong>{{ $errors->first('magnitude') }}</strong>
                              </span>
                            @endif
                         </div>
                         <!-- <div class="form-group">
                            <label>Fecha ultima calibración: (*)</label> 
                            {{ Form::date('date_last_calibration', $product->date_last_calibration, ['class' => 'form-control']) }}
                            @if ($errors->has('date_last_calibration'))
                              <span class="error-validate">
                                 <strong>{{ $errors->first('date_last_calibration') }}</strong>
                              </span>
                            @endif
                         </div>
                         <div class="form-group">
                            <label>Fecha aprox. control de calibración: (*)</label> 
                            {{ Form::date('date_control_calibration', $product->date_control_calibration, ['class' => 'form-control']) }}
                            @if ($errors->has('date_control_calibration'))
                              <span class="error-validate">
                                 <strong>{{ $errors->first('date_control_calibration') }}</strong>
                              </span>
                            @endif
                         </div> -->
                         <div class="form-group">
                           <label>Estado: (*)</label> 
                           {{ Form::select('status', array(0 => 'Equipo vencido', 1 => 'Equipo vigente'), $product->status, ['class' => 'form-control']) }}
                           @if ($errors->has('status'))
                             <span class="error-validate">
                                <strong>{{ $errors->first('status') }}</strong>
                             </span>
                           @endif
                        </div>
                        <!-- <div class="form-group">
                           <label>Despachado: (*)</label> 
                           {{ Form::select('delivery_status', array(0 => 'En proceso de calibración', 1 => 'Calibrado'), $product->delivery_status, ['class' => 'form-control']) }}
                           @if ($errors->has('delivery_status'))
                             <span class="error-validate">
                                <strong>{{ $errors->first('delivery_status') }}</strong>
                             </span>
                           @endif
                        </div> -->
                        <div class="form-group">
                            <label>Otros: </label> 
                            {{ Form::text('others', $product->others, ['class' => 'form-control']) }}
                            @if ($errors->has('others'))
                              <span class="error-validate">
                                 <strong>{{ $errors->first('others') }}</strong>
                              </span>
                            @endif
                         </div>
                        <div class="submit-button">
                           {{ Form::submit('Guardar', ['class' => 'btn btn-sm btn-primary pull-left m-t-n-xs']) }}
                        </div>
                     </div>
                  </div>
               </div>
               {{ Form::close() }}
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Modal for new client -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Nueva empresa</h4>
      </div>
      <div class="modal-body">
        {{ Form::open(['route' => 'clients.storeFromProduct']) }}
            @include('dashboard.clients.partials.form')
        {{ Form::close() }}
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

<!-- Modal for new Fabricator -->
<div class="modal fade" id="ModalFabricator" tabindex="-1" role="dialog" aria-labelledby="ModalFabricatorLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="ModalFabricatorLabel">Nuevo Fabricante</h4>
      </div>
      <div class="modal-body">
        {{ Form::open(['route' => 'fabricators.storeFromProduct']) }}
            @include('dashboard.fabricators.partials.form')
        {{ Form::close() }}
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>
@endsection