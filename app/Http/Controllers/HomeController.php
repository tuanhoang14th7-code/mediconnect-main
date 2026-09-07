<?php

namespace App\Http\Controllers;

use App\Models\MedicalContent;

class HomeController extends Controller
{
    public function index()
    {
        $diseases = MedicalContent::where('content_type', 'Disease')
            ->where('status', 'Published')
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        $preventions = MedicalContent::where('content_type', 'Prevention')
            ->where('status', 'Published')
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        $cures = MedicalContent::where('content_type', 'Cure')
            ->where('status', 'Published')
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        $medicalNews = MedicalContent::where('content_type', 'MedicalNews')
            ->where('status', 'Published')
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        $medicalInventions = MedicalContent::where('content_type', 'MedicalInvention')
            ->where('status', 'Published')
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('index', compact(
            'diseases',
            'preventions',
            'cures',
            'medicalNews',
            'medicalInventions'
        ));
    }
}