@extends('patient.PatientLayout')

@section('patient-content')

<div class="container my-5 min-vh-100">

    {{-- Header --}}
    <div class="text-center mb-5">

        <h2 class="black mb-2">
            Medical Knowledge
        </h2>

        <p class="pra mb-0">
            Explore useful health information,
            medical news and prevention guidance.
        </p>

    </div>
    {{-- Search and Filter --}}
    <div class="bg-white
                rounded-4
                shadow-sm
                p-4
                mb-5">

        <form
            action="{{ route('patient.medical.contents') }}"
            method="GET"
        >

            <div class="row g-3 align-items-end">

                {{-- Search --}}
                <div class="col-lg-6">

                    <label
                        for="search"
                        class="fw-semibold mb-2"
                    >
                        Search
                    </label>

                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Search medical content..."
                    >

                </div>


                {{-- Type Filter --}}
                <div class="col-lg-4">

                    <label
                        for="type"
                        class="fw-semibold mb-2"
                    >
                        Content Type
                    </label>

                    <select
                        name="type"
                        id="type"
                        class="medical-content-type"
                    >

                        <option value="">
                            All Types
                        </option>

                        <option
                            value="Disease"
                            {{ request('type') === 'Disease'
                                ? 'selected'
                                : '' }}
                        >
                            Disease
                        </option>

                        <option
                            value="Prevention"
                            {{ request('type') === 'Prevention'
                                ? 'selected'
                                : '' }}
                        >
                            Prevention
                        </option>

                        <option
                            value="Cure"
                            {{ request('type') === 'Cure'
                                ? 'selected'
                                : '' }}
                        >
                            Cure
                        </option>

                        <option
                            value="MedicalNews"
                            {{ request('type') === 'MedicalNews'
                                ? 'selected'
                                : '' }}
                        >
                            Medical News
                        </option>

                        <option
                            value="MedicalInvention"
                            {{ request('type') === 'MedicalInvention'
                                ? 'selected'
                                : '' }}
                        >
                            Medical Invention
                        </option>

                    </select>

                </div>


                {{-- Button --}}
                <div class="col-lg-2">

                    <button
                        type="submit"
                        class="common-btn
                            box-style
                            p2-bg
                            w-100
                            fs16
                            fw-semibold
                            white
                            overflow-hidden
                            rounded100"
                        style="padding: 10px 20px;"
                    >
                        Search
                    </button>

                </div>

            </div>


            @if (
                request()->filled('search') ||
                request()->filled('type')
            )

                <div class="mt-3">

                    <a
                        href="{{ route(
                            'patient.medical.contents'
                        ) }}"
                        class="text-decoration-none"
                    >
                        Clear Search
                    </a>

                </div>

            @endif

        </form>

    </div>

    @if (
        request()->filled('search') ||
        request()->filled('type')
    )

        <div class="mb-4">

            <p class="pra mb-0">

                Found

                <strong>
                    {{ $contents->total() }}
                </strong>

                result(s).

            </p>

        </div>

    @endif


    @if ($contents->isEmpty())

        <div class="bg-white
                    rounded-4
                    shadow-sm
                    p-5
                    text-center">

            <h4 class="black mb-2">
                No Medical Content Available
            </h4>

            <p class="pra mb-0">
                Published medical content will
                appear here.
            </p>

        </div>

    @else

        <div class="row g-4">

            @foreach ($contents as $content)

                <div class="col-lg-4 col-md-6">

                    <div class="bg-white
                                rounded-4
                                shadow-sm
                                overflow-hidden
                                h-100">

                        {{-- Image --}}
                        @if ($content->featured_image)

                            <img
                                src="{{ asset(
                                    'storage/'
                                    . $content->featured_image
                                ) }}"
                                alt="{{ $content->title }}"
                                class="w-100"
                                style="
                                    height: 220px;
                                    object-fit: cover;
                                "
                            >

                        @else

                            <img
                                src="{{ asset(
                                    'assets/img/blog/blog2-v1.jpg'
                                ) }}"
                                alt="{{ $content->title }}"
                                class="w-100"
                                style="
                                    height: 220px;
                                    object-fit: cover;
                                "
                            >

                        @endif


                        <div class="p-4">

                            {{-- Content Type --}}
                            <div class="mb-2">

                                <span
                                    class="badge rounded-pill"
                                    style="
                                        background-color: #18b7ad;
                                        padding: 7px 12px;
                                    "
                                >

                                    @switch($content->content_type)

                                        @case('MedicalNews')
                                            Medical News
                                            @break

                                        @case('MedicalInvention')
                                            Medical Invention
                                            @break

                                        @default
                                            {{ $content->content_type }}

                                    @endswitch

                                </span>

                            </div>


                            {{-- Title --}}
                            <h4 class="black mb-3">

                                {{ $content->title }}

                            </h4>


                            {{-- Summary --}}
                            <p class="pra mb-3">

                                {{ \Illuminate\Support\Str::limit(
                                    $content->summary
                                        ?? strip_tags(
                                            $content->body
                                        ),
                                    140
                                ) }}

                            </p>


                            {{-- Published Date --}}
                            @if ($content->published_at)

                                <small class="text-muted">

                                    Published:
                                    {{ $content
                                        ->published_at
                                        ->format('d/m/Y') }}

                                </small>

                            @endif

                            <div class="mt-4">

                                <a
                                    href="{{ route(
                                        'patient.medical.contents.show',
                                        $content->slug
                                    ) }}"
                                    class="common-btn
                                        box-style
                                        p2-bg
                                        d-inline-flex
                                        justify-content-center
                                        align-items-center
                                        fs16
                                        fw-semibold
                                        white
                                        overflow-hidden
                                        rounded100"
                                    style="padding: 9px 20px;"
                                >
                                    Read More
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>


        {{-- Pagination --}}
        @if ($contents->hasPages())

            <div class="mt-5
                        d-flex
                        justify-content-center">

                {{ $contents->links() }}

            </div>

        @endif

    @endif

</div>

@endsection