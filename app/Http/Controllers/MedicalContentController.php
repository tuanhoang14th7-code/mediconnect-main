<?php

namespace App\Http\Controllers;

use App\Models\MedicalContent;
use Illuminate\Http\Request;

class MedicalContentController extends Controller
{
    // Medical Content List + Search + Filter
    public function index(Request $request)
    {
        $query = MedicalContent::query()
            ->where('status', 'Published')
            ->whereNotNull('published_at')
            ->where(
                'published_at',
                '<=',
                now()
            );


        // Search by keyword
        if ($request->filled('search')) {

            $search = trim(
                $request->search
            );

            $query->where(function ($q) use ($search) {

                $q->where(
                    'title',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'summary',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'body',
                    'like',
                    '%' . $search . '%'
                );

            });
        }


        // Filter by content type
        $allowedTypes = [
            'Disease',
            'Prevention',
            'Cure',
            'MedicalNews',
            'MedicalInvention',
        ];


        if (
            $request->filled('type') &&
            in_array(
                $request->type,
                $allowedTypes
            )
        ) {

            $query->where(
                'content_type',
                $request->type
            );
        }


        $contents = $query
            ->orderByDesc('published_at')
            ->paginate(9)
            ->withQueryString();


        return view(
            'patient.PatientMedicalContents',
            compact('contents')
        );
    }


    // Medical Content Detail
    public function show($slug)
    {
        $content = MedicalContent::where(
                'slug',
                $slug
            )
            ->where(
                'status',
                'Published'
            )
            ->whereNotNull(
                'published_at'
            )
            ->where(
                'published_at',
                '<=',
                now()
            )
            ->firstOrFail();


        return view(
            'patient.PatientMedicalContentDetail',
            compact('content')
        );
    }
}