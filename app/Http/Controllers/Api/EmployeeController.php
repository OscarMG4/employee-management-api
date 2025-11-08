<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EmployeeController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $perPage = min($request->get('per_page', 15), 100);
        $employees = Employee::orderBy('created_at', 'desc')->paginate($perPage);

        return EmployeeResource::collection($employees);
    }

    public function search(Request $request): AnonymousResourceCollection
    {
        $query = Employee::query();

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('department')) {
            $query->byDepartment($request->department);
        }

        if ($request->filled('position')) {
            $query->byPosition($request->position);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sortField = $request->input('sort_by', 'created_at');
        $sortDirection = $request->input('sort_direction', 'desc');
        
        $allowedSortFields = ['name', 'email', 'position', 'salary', 'hire_date', 'department', 'created_at'];
        
        if (in_array($sortField, $allowedSortFields)) {
            $query->orderBy($sortField, $sortDirection);
        }

        $perPage = min($request->input('per_page', 15), 100);
        $page = $request->input('page', 1);

        $employees = $query->paginate($perPage, ['*'], 'page', $page);

        return EmployeeResource::collection($employees);
    }

    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        $employee = Employee::create($request->validated());

        return (new EmployeeResource($employee))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Employee $employee): EmployeeResource
    {
        return new EmployeeResource($employee);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee): EmployeeResource
    {
        $employee->update($request->validated());

        return new EmployeeResource($employee);
    }

    public function destroy(Employee $employee): JsonResponse
    {
        $employee->delete();

        return response()->json([
            'message' => 'Empleado eliminado exitosamente',
        ], 200);
    }

    public function statistics(): JsonResponse
    {
        $stats = [
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('status', 'active')->count(),
            'inactive_employees' => Employee::where('status', 'inactive')->count(),
            'departments_count' => Employee::distinct('department')->count('department'),
            'average_salary' => Employee::avg('salary'),
            'total_payroll' => Employee::where('status', 'active')->sum('salary'),
            'by_department' => Employee::selectRaw('department, COUNT(*) as count')
                ->groupBy('department')
                ->orderBy('count', 'desc')
                ->get(),
            'recent_hires' => Employee::where('hire_date', '>=', now()->subMonths(3))
                ->count(),
        ];

        return response()->json($stats);
    }

    public function departments(): JsonResponse
    {
        $departments = Employee::distinct()
            ->orderBy('department')
            ->pluck('department');

        return response()->json($departments);
    }

    public function positions(): JsonResponse
    {
        $positions = Employee::distinct()
            ->orderBy('position')
            ->pluck('position');

        return response()->json($positions);
    }
}
