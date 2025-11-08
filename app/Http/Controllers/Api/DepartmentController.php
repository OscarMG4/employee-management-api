<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DepartmentController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Department::query()->with('parent', 'children');

        if ($request->filled('search')) {
            $search = $request->search;
            $searchColumn = $request->input('search_column', 'name');
            
            if ($searchColumn === 'name') {
                $query->where('name', 'like', "%{$search}%");
            } elseif ($searchColumn === 'ambassador_name') {
                $query->where('ambassador_name', 'like', "%{$search}%");
            } else {
                $query->search($search);
            }
        }

        if ($request->filled('level')) {
            $levels = is_array($request->level) ? $request->level : [$request->level];
            $query->whereIn('level', $levels);
        }

        if ($request->filled('name')) {
            $names = is_array($request->name) ? $request->name : [$request->name];
            $query->whereIn('name', $names);
        }

        if ($request->filled('parent_name')) {
            $parentNames = is_array($request->parent_name) ? $request->parent_name : [$request->parent_name];
            $query->whereHas('parent', function ($q) use ($parentNames) {
                $q->whereIn('name', $parentNames);
            });
        }

        if ($request->filled('min_employees')) {
            $query->where('employee_count', '>=', $request->min_employees);
        }

        if ($request->filled('max_employees')) {
            $query->where('employee_count', '<=', $request->max_employees);
        }

        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');
        
        $allowedSorts = ['name', 'level', 'employee_count', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $perPage = min($request->input('per_page', 10), 100);
        $departments = $query->paginate($perPage);

        return DepartmentResource::collection($departments);
    }

    public function store(StoreDepartmentRequest $request): JsonResponse
    {
        $department = Department::create($request->validated());
        $department->load('parent', 'children');

        return (new DepartmentResource($department))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Department $department): DepartmentResource
    {
        $department->load('parent', 'children');
        return new DepartmentResource($department);
    }

    public function subdepartments(Department $department): AnonymousResourceCollection
    {
        $subdepartments = $department->children()->with('children')->get();
        return DepartmentResource::collection($subdepartments);
    }

    public function update(UpdateDepartmentRequest $request, Department $department): DepartmentResource
    {
        $department->update($request->validated());
        $department->load('parent', 'children');

        return new DepartmentResource($department);
    }

    public function destroy(Department $department): JsonResponse
    {
        $department->delete();

        return response()->json([
            'message' => 'Departamento eliminado exitosamente',
        ], 200);
    }
}
