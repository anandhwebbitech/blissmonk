<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
class WebinarController extends Controller
{
    //
    // 1. Display list of webinars (Admin view)
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Webinar::query()->latest();

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('banner_image', function ($row) {
                    if ($row->banner_image) {
                        $imageUrl = asset('upload/banner_image/' . $row->banner_image);
                        return '<img src="' . $imageUrl . '" width="80" height="45" style="border-radius:6px; object-fit: cover; border: 1px solid #e2e8f0;">';
                    }
                    return '<div style="width:80px; height:45px; background:#f1f5f9; border-radius:6px; display:flex; align-items:center; justify-content:center; col:#94a3b8; font-size:10px; font-weight:600;">No Image</div>';
                })
                // 2. Date Formatting (Readable format)
                ->editColumn('webinar_date', function ($row) {
                    return '<div>
                                <span class="fw-semibold d-block text-dark">' . date('d M, Y', strtotime($row->webinar_date)) . '</span>
                                <small class="text-muted">' . date('h:i A', strtotime($row->webinar_date)) . ' (' . $row->duration_minutes . ' Mins)</small>
                            </div>';
                })
                // 3. Meeting Link Button Formatting
                ->editColumn('meeting_link', function ($row) {
                    return '<a href="' . $row->meeting_link . '" target="_blank" class="btn btn-sm btn-light text-primary fw-medium" style="border-radius: 6px; font-size:12px; border: 1px solid #e2e8f0;">
                                <i class="fa fa-external-link me-1"></i> Join Link
                            </a>';
                })
                // 4. Multi-Status Badge Formatting (upcoming, live, completed)
                ->editColumn('status', function ($row) {
                    if ($row->status == 'live') {
                        return '<span class="badge" style="background-color: rgba(220, 38, 38, 0.1); color: #dc2626; padding: 6px 12px; border-radius: 6px; font-weight:600;"><i class="fa-solid fa-circle-dot fa-fade me-1"></i> Live</span>';
                    } elseif ($row->status == 'completed') {
                        return '<span class="badge" style="background-color: rgba(71, 85, 105, 0.1); color: #475569; padding: 6px 12px; border-radius: 6px; font-weight:600;">Completed</span>';
                    }
                    return '<span class="badge" style="background-color: rgba(22, 101, 52, 0.1); color: #166534; padding: 6px 12px; border-radius: 6px; font-weight:600;">Upcoming</span>';
                })
                // 5. Action Buttons (Edit and Delete)
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.webinars.edit', $row->id);
                    $deleteRoute = route('admin.webinars.destroy', $row->id);
                    
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
                ->rawColumns(['banner_image', 'webinar_date', 'meeting_link', 'status', 'action'])
                ->make(true);
        }

        return view('admin.webinars.index');
    }
    public function create()
    {
        return view('admin.webinars.create');
    }

    // 2. Store new webinar details
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'webinar_date' => 'required|date', 
            'duration_minutes' => 'required|integer|min:1',
            'speaker_name' => 'required|string|max:255',
            'meeting_link' => 'required|url',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'status' => 'required|string|in:upcoming,live,completed',
        ]);

        if ($request->status === 'live') {
            $existingLive = Webinar::where('status', 'live')->exists();
            if ($existingLive) {
                return response()->json([
                    'status' => false,
                    'message' => 'Another webinar is currently live! Only one webinar can be live at a time.'
                ], 422); // 422 Unprocessable Entity
            }
        }

        try {
            $data = $request->only([
                'title', 'description', 'webinar_date', 
                'duration_minutes', 'speaker_name', 'meeting_link', 'status'
            ]);

            if ($request->hasFile('banner_image')) {
                $file = $request->file('banner_image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/banner_image'), $filename);
                $data['banner_image'] = $filename;
            }

            Webinar::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Webinar details scheduled and stored successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Database Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // 3. Update existing webinar details
    public function update(Request $request, $id)
    {
        $webinar = Webinar::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'webinar_date' => 'required|date', 
            'duration_minutes' => 'required|integer|min:1',
            'speaker_name' => 'required|string|max:255',
            'meeting_link' => 'required|url',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'status' => 'required|string|in:upcoming,live,completed',
        ]);

        if ($request->status === 'live') {
            $existingLive = Webinar::where('status', 'live')->where('id', '!=', $id)->exists();
            if ($existingLive) {
                return response()->json([
                    'status' => false,
                    'message' => 'Another webinar is currently live! Please complete it before activating this one.'
                ], 422);
            }
        }

        try {
            $data = $request->only([
                'title', 'description', 'webinar_date', 
                'duration_minutes', 'speaker_name', 'meeting_link', 'status'
            ]);

            if ($request->hasFile('banner_image')) {
                if ($webinar->banner_image && file_exists(public_path('upload/banner_image/' . $webinar->banner_image))) {
                    @unlink(public_path('upload/banner_image/' . $webinar->banner_image));
                }

                $file = $request->file('banner_image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/banner_image'), $filename);
                $data['banner_image'] = $filename;
            }

            $webinar->update($data);

            return response()->json([
                'status' => true,
                'message' => 'Webinar details updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Database Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function edit($id)
    {
        $webinar = Webinar::findOrFail($id);
        
        return view('admin.webinars.edit', compact('webinar'));
    }
    public function destroy($id)
    {
        try {
            $webinar = Webinar::findOrFail($id);

            if ($webinar->banner_image && file_exists(public_path('upload/banner_image/' . $webinar->banner_image))) {
                @unlink(public_path('upload/banner_image/' . $webinar->banner_image));
            }

            $webinar->delete();

            return response()->json([
                'status' => true,
                'message' => 'Webinar has been successfully removed from the schedule.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete: ' . $e->getMessage()
            ], 500);
        }
    }
}
