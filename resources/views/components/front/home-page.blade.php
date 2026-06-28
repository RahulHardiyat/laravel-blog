<x-front.layout>
    {{--slot Header--}}
    <x-slot name="pageHeader" >
        {{ $newestData->title }}
    </x-slot>
    <x-slot name="pageBackground" >
        {{ asset(getenv('CUSTOM_THUMBNAIL_LOCATION')."/".$newestData->thumbnail) }}
    </x-slot>
    <x-slot name="pageHeaderLink" >
        {{ route('blog.detail', ['slug'=>$newestData->slug]) }}
    </x-slot>
    <x-slot name="pageSubHeader" >
        {{ $newestData->description }}
    </x-slot>
{{--slot header--}}

    <!-- Main Content-->
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                @foreach($data as $key => $values)
                    <x-front.blog-list title="{{ $values->title }}"
                                       description=" {{ $values->description }}"
                                       date="{{ $values->created_at->isoFormat('dddd, D MMMM Y') }}"
                                       user="{{ $values->user->name }}"
                                       link="{{ route('blog.detail', ['slug' => $values->slug]) }}"/>
                @endforeach
                <!-- Post preview-->

                <!-- Pager-->
                    <div class="d-flex justify-content-between mb-4">
                        <div>
                            @if(!$data->onFirstPage())
                                <a class="btn btn-primary text-uppercase" href="{{ $data->previousPageUrl() }}">&leftarrow;Newest Post</a>
                           @endif
                        </div>
                        <div>
                            @if($data->hasMorePages())
                                <a class="btn btn-primary text-uppercase" href="{{ $data->nextPageUrl() }}">Older Posts&rightarrow;</a>
                           @endif
                        </div>
                    </div>
            </div>
        </div>
    </div>

</x-front.layout>

