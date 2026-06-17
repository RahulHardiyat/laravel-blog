@props(['name', 'id'])

<select name="{{$name}}" id="{{ $id }}" class="border-gray-300 rounded-md">
    {{ $slot }}
</select>
