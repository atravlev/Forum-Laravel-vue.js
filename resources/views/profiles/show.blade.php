@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="pb-2 mt-4 mb-2 border-bottom">
               <avatar-form :user="{{$profileUser}}"></avatar-form>
            </div>

            @forelse($activities as $date => $activity)
                <div class="pb-2 mt-4 mb-2 border-bottom">
                    <h3>{{ $date }}</h3>
                </div>
                @foreach($activity as $record)
                    @includeif("profiles.activities.{$record->type}", ['activity' => $record])
                @endforeach
            @empty
                <p>There is no activity for this user yet.</p>
            @endforelse
        </div>
    </div> 
</div>
@endsection