<x-layouts.main>
    <x-slot:title>
        Post Yaratish
    </x-slot:title>

    <x-page-header>
        Yangi Post Yaratish
    </x-page-header>

    <div class="container">
        <div class="w-60 py-5">
            <div class="contact-form" style="padding-left: 10%">
                <div id="success"></div>

                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}

                <form action="{{ route('posts.store') }}" method="POST">
                    @csrf

                    <div class="control-group">
                        <input type="text" class="form-control p-4" id="subject" placeholder="Sarlavha"
                            name="title" />
                        @error('title')
                            <div class="alert text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="control-group">
                        <textarea class="form-control p-4" rows="3" name="short_content" id="message" placeholder="Qisqacha Mazmuni"></textarea>
                    </div>

                    <div class="control-group">
                        <textarea class="form-control p-4" rows="6" id="message" name="content" placeholder="Maqola"></textarea>
                        <p class="help-block text-danger"></p>
                    </div>

                    {{-- <div class="control-group">
                        <input type="file" class="form-control p-4" placeholder="Rasm" />
                        <p class="help-block text-danger"></p>
                    </div> --}}

                    <div>
                        <button class="btn btn-primary btn-block py-4 px-5" type="submit">Saqlash</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
    </div>


</x-layouts.main>
