<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @isset($current)
            <li class="breadcrumb-item"><a class="nav-link" href="{{route('employee.dashboard')}}">Dashboard</a>
            </li>
            @isset($group)
                <li class="breadcrumb-item"><a class="nav-link" href="{{route("$group.index")}}">{{ucfirst($group)}}</a>
                </li>
                @isset($id)
                    <li class="breadcrumb-item"><a class="nav-link" href="{{route("$group.show", $id)}}">Details</a>
                    </li>
                @endisset
            @endisset
            <li class="breadcrumb-item active" aria-current="page">{{ucfirst($current)}}</li>
        @else
            <li class="breadcrumb-item" aria-current="page">Dashboard</li>
        @endisset 
    </ol>
</nav>