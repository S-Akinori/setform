<x-app-layout>
    <form action="{{route('form.answer')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="max-w-2xl m-auto">
        @foreach ($form->formats as $format)
            <div>
                <h2 class="text-xl text-center py-3 w-full rounded-lg bg-blue-100 focus:bg-white">{{$format['title']}}<span class="text-red-500"> *</span></h2>
    
                @foreach ($format['inputs'] as $input)
                    @if($format['type'] == 'checkbox' || $format['type'] == 'radio' )
                        <!-- checkbox and radio button -->
                        <div class="flex justify-center">
                            <div>
                                <div class="my-3 flex items-center">
                                    <input id="input{{$format['id']}}_{{$input['id']}}" type="{{$format['type']}}" name="{{$format['name']}}" value="{{$input['label']}}">
                                    <label for="input{{$format['id']}}_{{$input['id']}}">{{$input['label']}}</label>
                                </div>
                            </div>
                        </div>
                    @elseif($format['type'] == 'textarea')
                        <div class="flex justify-center">
                            <div class="w-3/4">
                                <div class="my-3">
                                    <label for="input{{$format['id']}}_{{$input['id']}}">{{$input['label']}}</label>
                                    <textarea id="input{{$format['id']}}_{{$input['id']}}" name="{{$format['name']}}" rows="5"  class="my-3 w-full block border border-gray-300 rounded focus:outline-none focus:ring-1 focus:border-indigo-400"></textarea>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex justify-center">
                            <div class="w-3/4">
                                <div class="my-3">
                                    <label for="input{{$format['id']}}_{{$input['id']}}">{{$input['label']}}</label>
                                    <input id="input{{$format['id']}}_{{$input['id']}}" type="{{$format['type']}}" name="{{$format['name']}}" class="block my-3 py-1 w-full border border-gray-300 rounded focus:outline-none focus:ring-1 focus:border-indigo-400">
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endforeach
        </div>

        <input type="hidden" name="id" value="{{$form->id}}">
        <button type="submit">送信</button>
    </form>
</x-app-layout>