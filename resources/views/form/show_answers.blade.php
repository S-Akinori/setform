<x-app-layout>
    <p>form id : {{$form_answer->form_id}}</p>

    @foreach ($form_answer['answers'] as $answer => $value)
        <div>
            <h2 class="bg-gray-200">{{$answer}}</h2>
            @if (is_array($value))
                @foreach ($value as $key => $value1)
                    <p>{{$value1}}</p>
                @endforeach
            @else
                <p>{{$value}}</p>
            @endif
        </div>
    @endforeach
</x-app-layout>