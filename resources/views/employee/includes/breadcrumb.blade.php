<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="nav-link" href="{{route('employee.dashboard')}}">Dashboard</a>
        </li>

        @isset($group)
            <li class="breadcrumb-item"><a class="nav-link" href="{{route("$group.index")}}">{{ucfirst($group)}}</a>
            </li>
        @endisset
        @isset($id)
            <li class="breadcrumb-item"><a class="nav-link" href="{{route("$group.show", $id)}}">Details</a>
            </li>
        @endisset
        @isset($current)
            <li class="breadcrumb-item active" aria-current="page">{{ucfirst($current)}}</li>
        @endisset 

    </ol>
</nav>