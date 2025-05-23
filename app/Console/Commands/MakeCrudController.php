<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class MakeCrudController extends Command
{
    protected $signature = 'make:crud-controller {name} {--fields=}';
    protected $description = 'Generate a CRUD controller, route, and views for a given API resource';

    public function handle()
    {
        $name = $this->argument('name');
        $className = Str::studly($name);
        $resource = Str::kebab($name);

        $fieldsOption = $this->option('fields');
        $fieldsArray = [];

        if ($fieldsOption) {
            $fieldsRaw = explode(',', $fieldsOption);
            foreach ($fieldsRaw as $field) {
                [$fieldName, $type] = explode(':', $field);
                $fieldsArray[$fieldName] = $type;
            }
        }

        $validationRules = collect($fieldsArray)->map(function ($type, $field) {
            $rule = match ($type) {
                'email' => 'required|email',
                default => 'required|string',
            };
            return "'$field' => '$rule'";
        })->implode(",\n            ");

        $requestFields = collect(array_keys($fieldsArray))
            ->map(fn($f) => "'$f'")
            ->implode(', ');

        // Generate Controller
        $stubPath = base_path('stubs/crud-controller.stub');
        if (!File::exists($stubPath)) {
            $this->error("❌ File stub tidak ditemukan: $stubPath");
            return;
        }

        $stub = File::get($stubPath);

        $content = str_replace(
            ['{{className}}', '{{resource}}', '{{validationRules}}', '{{requestFields}}'],
            [$className, $resource, $validationRules, $requestFields],
            $stub
        );

        $controllerPath = app_path("Http/Controllers/{$className}Controller.php");

        if (File::exists($controllerPath)) {
            $this->error("❌ Controller {$className}Controller sudah ada.");
            return;
        }

        File::put($controllerPath, $content);
        $this->info("✅ Controller {$className}Controller berhasil dibuat.");

        // Tambahkan route ke web.php
        $routeLine = "Route::resource('$resource', App\\Http\\Controllers\\{$className}Controller::class);";
        $routesFile = base_path('routes/web.php');

        if (!Str::contains(File::get($routesFile), $routeLine)) {
            File::append($routesFile, "\n$routeLine\n");
            $this->info("✅ Route berhasil ditambahkan ke web.php");
        } else {
            $this->warn("⚠️ Route sudah ada di web.php");
        }

        // Generate views (index only for now)
        $viewDir = resource_path("views/admin/{$resource}");
        if (!File::exists($viewDir)) {
            File::makeDirectory($viewDir, 0755, true);
        }

        $fieldsTh = collect(array_keys($fieldsArray))->map(fn($f) => "<th class=\"px-6 py-3\">" . Str::title($f) . "</th>")->implode("\n");
        $fieldsTd = collect(array_keys($fieldsArray))->map(fn($f) => "<td class=\"px-6 py-4\">{{ \$item['$f'] }}</td>")->implode("\n");

        $viewContent = <<<BLADE
@extends('layouts.admin')

@section('title', 'Daftar ' . ucfirst('{$resource}'))

@section('content')
    <h3 class="text-2xl font-bold">Daftar {$className}</h3>
    <a href="{{ route('{$resource}.create') }}" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded">Tambah {$className}</a>

    <div class="mt-6">
        <table class="min-w-full" id="myTable" class="display">
            <thead>
                <tr>
                    {$fieldsTh}
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\${$resource} as \$item)
                    <tr>
                        {$fieldsTd}
                        <td class="px-6 py-4">
                            <a href="{{ route('{$resource}.edit', \$item['id']) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('{$resource}.destroy', \$item['id']) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 ml-2">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
BLADE;

        File::put("{$viewDir}/index.blade.php", $viewContent);
        $this->info("✅ View index.blade.php berhasil dibuat di {$viewDir}");

// Generate edit view
$fieldsForm = collect($fieldsArray)->map(function ($type, $field) {
    $inputType = $type === 'email' ? 'email' : 'text';
    return <<<HTML
<div>
    <label for="{$field}" class="block text-sm font-medium text-gray-700">{$field}</label>
    <input type="{$inputType}" name="{$field}" id="{$field}" value="{{ old('{$field}', \$item['{$field}']) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
    @error('{$field}')
        <p class="mt-1 text-sm text-red-600">{{ \$message }}</p>
    @enderror
</div>
HTML;
})->implode("\n\n");

$editViewContent = <<<BLADE
@extends('layouts.admin')

@section('title', 'Edit {$className}')

@section('content')
    <div class="flex justify-between items-center">
        <h3 class="text-3xl font-medium text-gray-700">Edit {$className}</h3>
        <a href="{{ route('{$resource}.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="mt-8">
        <div class="mt-8 bg-white p-6 rounded-md shadow-md">
            <form action="{{ route('{$resource}.update', \$item['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {$fieldsForm}
                </div>

                <div class="mt-6">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        <i class="fas fa-save mr-2"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
BLADE;

File::put("{$viewDir}/edit.blade.php", $editViewContent);
$this->info("✅ View edit.blade.php berhasil dibuat di {$viewDir}");

// Generate create view
$fieldsCreateForm = collect($fieldsArray)->map(function ($type, $field) {
    $inputType = $type === 'email' ? 'email' : 'text';
    return <<<HTML
<div>
    <label for="{$field}" class="block text-sm font-medium text-gray-700">{$field}</label>
    <input type="{$inputType}" name="{$field}" id="{$field}" value="{{ old('{$field}') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
    @error('{$field}')
        <p class="mt-1 text-sm text-red-600">{{ \$message }}</p>
    @enderror
</div>
HTML;
})->implode("\n\n");

$createViewContent = <<<BLADE
@extends('layouts.admin')

@section('title', 'Tambah {$className}')

@section('content')
    <div class="flex justify-between items-center">
        <h3 class="text-3xl font-medium text-gray-700">Tambah {$className}</h3>
        <a href="{{ route('{$resource}.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="mt-8">
        <div class="mt-8 bg-white p-6 rounded-md shadow-md">
            <form action="{{ route('{$resource}.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {$fieldsCreateForm}
                </div>

                <div class="mt-6">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
BLADE;

File::put("{$viewDir}/create.blade.php", $createViewContent);
$this->info("✅ View create.blade.php berhasil dibuat di {$viewDir}");
    }
}
