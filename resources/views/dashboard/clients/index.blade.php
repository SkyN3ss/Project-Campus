@extends('layouts.dashboard')
@section('title', 'Empresas Registrados: '.$client_count)
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
   <div class="col-lg-10">
      <h2>Empresas Registrados</h2>
      <ol class="breadcrumb">
         <li>
            <a href="{{ route('home') }}">Inicio</a>
         </li>
         <!-- <li>
            <a href="{{ route('client.pdf') }}">Reporte en PDF</a>
         </li> -->
      </ol>
   </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
      <div class="col-lg-12">
         <div class="ibox float-e-margins">
            <div class="ibox-title">
               <h5>Busqueda:</h5>
               <div class="ibox-tools">
                  <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                  </a>
               </div>
            </div>
            {{ Form::open(['route' => ['clients.search'], 'method' => 'GET', 'class' => 'form-inline']) }}
               <div class="ibox-content">
                  <div class="row">
                        <div class="form-group">
                        {{ Form::select('field', array('id' => 'ID', 'name' => 'Empresa', 'last_name' => 'Responsable', 'city' => 'Ciudad'), ['class' => 'form-control', 'id' => 'field']) }}
                        {!! Form::text('input', null, ['class' => 'form-control', 'id' => 'input']) !!}
                        </div>
                           {{ Form::submit('Buscar', ['class' => 'btn btn-sm btn-primary']) }}
                  </div>
               </div>
               {{ Form::close() }}
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-lg-12">
         <div class="ibox float-e-margins">
            <div class="ibox-title">
               <h5>Registrados: {{ $client_count }}</h5>
               <div class="ibox-tools">
                    <a href="{{ route('clients.create') }}" class="btn btn-primary btn-xs">Crear Empresa</a>
                </div>
               <div class="ibox-tools">
                  <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                  </a>
               </div>
            </div>
            <div class="ibox-content table-responsive">
              @include('alert.alerts')
               <table class="table responsive">
                  <thead>
                     <tr>
                        <th>#ID</th>
                        <th>Empresa</th>
                        <th>Rubro</th>
                        <th>Responsable</th>
                        <th>Ciudad</th>
                        <th>Dirección</th>
                        <th>Zona</th>
                        <th>Telefono</th>
                        <th>Celular</th>
                        <th>Correo</th>
                        <th>Pagina web</th>
                        <th>Registro</th>
                        <th>Opciones</th>
                        <th colspan="1">&nbsp;</th>
                     </tr>
                  </thead>
                  <tbody>
                  @foreach($clients as $client)
                    <tr>
                      <td>{{ $client->id }}</td>
                      <td>{{ $client->name }}</td>
                      <td>{{ $client->rubro }}</td>
                      <td>{{ $client->last_name }}</td>
                      <td>{{ $client->city }}</td>
                      <td>{{ $client->residency }}</td>
                      <td>{{ $client->zone }}</td>
                      <td>{{ $client->phone }}</td>
                      <td>{{ $client->fax }}</td>
                      <td>{{ $client->email }}</td>
                      <td>{{ $client->web_page }}</td>
                      <td>{{ $client->created_at->diffForHumans() }}</td>
                      @can('clients.edit')
                      <td width="10px">
                          <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-sm btn-info">
                              Editar
                          </a>
                      </td>
                      @endcan
                      @role('admin')
                      @can('clients.destroy')
                      <td width="10px">
                          {{ Form::open(['route' => ['clients.destroy', $client->id], 'method' => 'DELETE']) }}
                              <button class="btn btn-sm btn-danger" onclick="return confirm('Desea eliminar esta empresa?')">
                                  Eliminar
                              </button>
                          {{ Form::close() }}
                      </td>
                      @endcan
                      @endrole
                    </tr>
                    @endforeach
                </tbody>
               </table>
                {{ $clients->render() }}
            </div>
         </div>
      </div>
   </div>
</div>
@endsection