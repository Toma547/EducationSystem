@extends('layouts.app')

@section('content')
<div class="container">

    {{-- 名前 & 学年 --}}
    <h2>{{ $user->name }} さんの授業進捗</h2>
    <p>現在の学年：<span class="badge bg-info">{{ $user->grade }}</span></p>

   <div class="row">
      @foreach($grades as $grade)
    <div class="col-mb-4 mb-4">
        <h5 class="big-light p-2">{{ $grade }}</h5>
    <ul>
        @php
            $classes = $curriculums[$grade] ?? collect([]);
            $isActive = array_search($grade, $grades) <= array_search($user->grade, $grades);
        @endphp
            
        @foreach($classes as $class)
            @php
               $done = $progress[$class->id]->clear_flg ?? false;
            @endphp

           <li>
              @if($isActive)
                 {{-- 現在の学年以下なのでリンク有効 --}}
                 <a href="{{ url('/curriculums/'.$class->id) }}">
                    <span class="{{ $done ? 'text-danger fw-bold' : ''}}">
                        {{ $done ? '受講済' : ''}}{{ $class->title }}
                    </span>
                 </a>
                @else
                   {{-- 未来の学年なので非活性 --}}
                   <span class="text-muted">{{ $class->title }}</span>
                @endif 
           </li>
         @endforeach
        </ul>
      </div>
     @endforeach
   </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(function(){
        $(".toggle-btn").click(function(){
            let id = $(this).data("id");

            $.post("{{ route('progress.toggle') }}", {
                id: id,
                _token: "{{ csrf_token() }}"
            }, function(res){
                if(res.status === 'success'){
                    location.reload(); //更新
                }
            });
        });
    });
</script>
@endsection
