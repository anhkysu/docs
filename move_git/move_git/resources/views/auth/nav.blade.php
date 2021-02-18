<nav class="row navbar navbar-expand-lg navbar-light bg-light">
    <div >
        <ul class="navbar-nav mr-auto">
            @if (Auth::check())
            <li class="nav-item mr-3">
                <a class="nav-link text-primary" href="/iam/thoat">Hello, {!! Auth::User()->username !!}</a>
            </li>
            @endif

<?php 
    $mainNavigationList = [];
    $subNavigationList = [];
    if(Auth::check()){
        $userNavigationControl = Auth::User()->navigation_control;
        $userNavigationControl = json_decode($userNavigationControl, true);
        $navigationControlModel = new \App\Models\NavigationControl();
        $navigationControlList = $navigationControlModel->selectAllNavigationControl();
        foreach($navigationControlList as $navigationControl){
            if(isset($userNavigationControl[$navigationControl->attribute]) 
            && $userNavigationControl[$navigationControl->attribute] == \App\Constants\User::NAVIGATION_CONTROL_ACTION_ALLOW){ 
                if(empty($navigationControl->parent_id)){
                    $subNavigationList = [];
                    $parentId = $navigationControl->id;
                    foreach($navigationControlList as $subNavigationControl){
                        if(!empty($subNavigationControl->parent_id) 
                        && $subNavigationControl->parent_id == $parentId
                        && $userNavigationControl[$subNavigationControl->attribute] == \App\Constants\User::NAVIGATION_CONTROL_ACTION_ALLOW
                        ){
                            $subNavigationList[] = $subNavigationControl;
                        }
                    }
                    if(empty($subNavigationList)){
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="{{$navigationControl->link}}">{{$navigationControl->name}}</a>
                    </li>
                    
                    <?php
                    }else{
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{$navigationControl->name}}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @foreach($subNavigationList as $sub)
                                <a class="dropdown-item" href="{{$sub->link}}">{{$sub->name}}</a>
                            @endforeach
                        </div>
                    </li>
                        
                    <?php
                    }
                }
            }
        }
    }
?>
        </ul>
    </div>
</nav>