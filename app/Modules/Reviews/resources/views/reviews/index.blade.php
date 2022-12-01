<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>{{__('Reviews List')}}</h1>
    <h2>{{__('Submit your Review')}}</h2>
    <form action="{{route('reviews.store')}}" method="POST">
        @csrf
        <div>
            {{__('Rate this Item')}}
            @for ($i=config('reviews.rating.minimum'); $i<=config('reviews.rating.maximum'); $i++)
                <label>
                    <input type="radio" name="rating" value="{{$i}}">
                    {{$i}}
                </label>
            @endfor
        </div>
        <textarea name="" id="" cols="30" rows="10"></textarea>
        <button type="submit" name="submit">{{__('Submit')}} </button>
    </form>
</body>
</html>
