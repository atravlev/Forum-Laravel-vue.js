<div class="card" v-if="editing">
    <div class="card-header">
        <div class="level">
            <input class="form-control" type="text" v-model="form.title">
        </div>
    </div>

    <div class="card-body">
        <div class="form-group">
            <wysiwyg v-model="form.body"></wysiwyg>
        </div>  
    </div>

    <div class="card-footer">
        <div class="level">
            <div>
                <button class="btn btn-sm" @click="editing = true" v-show="! editing">Edit</button>
                <button class="btn btn-sm" @click="resetForm">Cancel</button>
                <button class="btn btn-sm btn-primary" @click="update">Update</button>

            </div>
            @can ('update', $thread)
                <form action="{{ $thread->path() }}" method="POST">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-link">Delete Thread</button>
                </form>
            @endcan
        </div>
    </div>
</div>

<div class="card" v-else>
    <div class="card-header">
        <div class="level">
            <span>
                <img class="mr-1" src="{{ asset($thread->creator->avatar_path) }}" width="50" height="50">
                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:
                <span v-text="title"></span>
            </span>
        </div>
    </div>
    <div class="card-body" v-html="body"></div>
    <div class="card-footer" v-if="authorize('owns',thread)">
        <button class="btn btn-sm" @click="editing = true">Edit</button>
    </div>
</div>