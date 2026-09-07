@extends('patient.PatientLayout')

@section('patient-content')

<div class="container my-5 min-vh-100">

    <div class="row justify-content-center">

        <div class="col-lg-9">


            {{-- Back --}}
            <div class="mb-4">

                <a
                    href="{{ route(
                        'patient.medical.contents'
                    ) }}"
                    class="text-decoration-none
                           fw-semibold"
                >
                    ← Back to Medical Knowledge
                </a>

            </div>


            <article
                class="bg-white
                       rounded-4
                       shadow-sm
                       overflow-hidden"
            >

                {{-- Featured Image --}}
                @if ($content->featured_image)

                    <img
                        src="{{ asset(
                            'storage/'
                            . $content->featured_image
                        ) }}"
                        alt="{{ $content->title }}"
                        class="w-100"
                        style="
                            max-height: 450px;
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
                            max-height: 450px;
                            object-fit: cover;
                        "
                    >

                @endif


                <div class="p-4 p-lg-5">


                    {{-- Type --}}
                    <div class="mb-3">

                        <span
                            class="badge rounded-pill"
                            style="
                                background-color: #18b7ad;
                                padding: 8px 14px;
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
                    <h1 class="black mb-3">

                        {{ $content->title }}

                    </h1>


                    {{-- Published Date --}}
                    @if ($content->published_at)

                        <div class="text-muted mb-4">

                            Published:

                            {{ $content
                                ->published_at
                                ->format('d/m/Y H:i') }}

                        </div>

                    @endif


                    {{-- Summary --}}
                    @if ($content->summary)

                        <div
                            class="border-start
                                   border-4
                                   ps-4
                                   mb-4"
                            style="
                                border-color:
                                #18b7ad !important;
                            "
                        >

                            <p
                                class="fw-semibold
                                       mb-0"
                            >
                                {{ $content->summary }}
                            </p>

                        </div>

                    @endif


                    {{-- Body --}}
                    <div
                        class="medical-content-body"
                        style="
                            line-height: 1.8;
                            font-size: 16px;
                        "
                    >

                        {!! nl2br(
                            e($content->body)
                        ) !!}

                    </div>


                    {{-- Source --}}
                    @if ($content->source_url)

                        <div
                            class="border-top
                                   mt-5
                                   pt-4"
                        >

                            <strong>
                                Source:
                            </strong>

                            <a
                                href="{{ $content->source_url }}"
                                target="_blank"
                                rel="noopener noreferrer"
                            >
                                View original source
                            </a>

                        </div>

                    @endif

                </div>

            </article>

        </div>

    </div>

</div>

@endsection