@extends('layouts.tabler')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="background: #1c1c1c; border: 1px solid #2c2c2c;">
                <div class="card-header">
                    <h3 class="card-title text-white">Editar Materia</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('subjects.update', $subject) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label text-white">Nombre</label>
                            <input type="text" 
                                   class="form-control bg-dark text-white @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $subject->name) }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label text-white">Descripción</label>
                            <textarea class="form-control bg-dark text-white @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3" 
                                      required>{{ old('description', $subject->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label text-white">Estado</label>
                            <select class="form-select bg-dark text-white @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status">
                                <option value="1" {{ old('status', $subject->status) ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('status', $subject->status) ? '' : 'selected' }}>Inactivo</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti ti-device-floppy"></i> Actualizar
                            </button>
                            <a href="{{ route('subjects.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left"></i> Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection