<x-app-layout>

    <form action="{{route('client.projects.update',$project->id)}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('client.projects._form')
    </form>

</x-app-layout>
