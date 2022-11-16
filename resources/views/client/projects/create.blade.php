<x-app-layout data='Create Project'>

        <form action="{{route('client.projects.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('client.projects._form')
        </form>

</x-app-layout>
