<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
class FaqController extends Controller
{
    //
    public function index(Request $request)
{
    if ($request->ajax()) {
        $query = Faq::query()->orderBy('sort_order', 'asc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('sort_order', function ($row) {
                return '<strong>' . sprintf('%02d', $row->sort_order) . '.</strong>';
            })
            ->editColumn('question', function ($row) {
                return '<span class="fw-semibold text-dark">' . e($row->question) . '</span>';
            })
            ->editColumn('highlight_answer', function ($row) {
                if ($row->highlight_answer) {
                    return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1 rounded">' . e($row->highlight_answer) . '</span>';
                }
                return '<span class="text-muted small">-</span>';
            })
            ->editColumn('full_answer', function ($row) {
                return '<span class="text-secondary">' . e(Str::limit($row->full_answer, 60)) . '</span>';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('admin.faqs.edit', $row->id);
                $deleteRoute = route('admin.faqs.destroy', $row->id);
                
                return '
                    <div class="d-flex justify-content-center gap-2">
                        <a href="' . $editUrl . '" class="btn btn-sm btn-outline-secondary" style="border-radius: 6px; padding: 5px 10px;" title="Edit">
                            <i class="fa fa-edit text-dark"></i>
                        </a>
                        <button type="button" data-route="' . $deleteRoute . '" class="btn btn-sm btn-outline-danger delete" style="border-radius: 6px; padding: 5px 10px;" title="Delete">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['sort_order', 'question', 'highlight_answer', 'full_answer', 'action'])
            ->make(true);
    }

    return view('admin.faqs.index');
}

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'highlight_answer' => 'nullable|string|max:50',
            'full_answer' => 'required|string',
            'sort_order' => 'required|integer|min:1',
        ]);

        try {
            Faq::create($request->all());
            return response()->json(['status' => true, 'message' => 'FAQ created successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);

        $request->validate([
            'question' => 'required|string|max:255',
            'highlight_answer' => 'nullable|string|max:50',
            'full_answer' => 'required|string',
            'sort_order' => 'required|integer|min:1',
        ]);

        try {
            $faq->update($request->all());
            return response()->json(['status' => true, 'message' => 'FAQ updated successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $faq = Faq::findOrFail($id);
            $faq->delete();
            return response()->json(['status' => true, 'message' => 'FAQ deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => 'Delete failed!'], 500);
        }
    }
}
