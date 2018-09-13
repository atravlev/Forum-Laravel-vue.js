@extends('layouts.app')

@section('content')
    <ais-index class="search-wrapper" 
        app-id="{{ config('scout.algolia.id')}}"
        api-key="{{ config('scout.algolia.key')}}"
        index-name="threads"
        query="{{ request('q')}}"
    >
        <div>
            <ais-results>
                <template scope="{ result }">
                    <li>
                        <a :href="result.path">
                            <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                        </a>
                    </li>
                </template>
            </ais-results>
        </div>
        
        <div>
            <div class="card">
                <div class="card-header">Search</div>
                <div class="card-body">
                    <ais-search-box placeholder="Find a thread..." :autofocus="true"></ais-search-box>
                </div>
            </div>
        
            <div class="card">
                <div class="card-header">Filter by Channel</div>
                <div class="card-body">
                    <ais-refinement-list attribute-name="channel.name"></ais-refinement-list>
                </div>
            </div>
        </div>
    </ais-index>
@endsection
