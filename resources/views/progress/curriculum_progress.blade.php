@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6">

<!-- 戻るリンク -->
 <div class="mb-4">
    <a href="javascript:history.back()" class="text-gray-700 font-semibold hover:underline">&larr; 戻る</a>
 </div>

<!-- プロフィール画像 & 名前 -->
 <div class="flex items-center mb-10">
    <div class="w-28 h-28 mr-6">
        @if($user->profile_image)
           <img src="{{ asset('storage/'.$user->profile_image) }}"
                alt="プロフィール画像"
                class="rounded-full w-28 h-28 object-cover border-2 border-300">
        @else
           <div class="w-28 h-28 flex items-center justify-center bg-gray-200 rounded-full text-gray-500 border-2 border-gray-300">
               Noimage
           </div>
        @endif      
    </div>
    <div>
        <h2 class="text-3xl font-bold">{{ $user->name }} さんの授業進捗</h2>
        <p class="mt-3 text-lg">現在の学年：
            <span class="px-4 py-1 bg-teal-300 text-white rounded-full text-base">
                {{ $currentGrade->name }}
            </span>
        </p>
    </div>
 </div>
   
 <!-- 学年ごとの授業 -->
   <div class="grid grid-cols-3 gap-8">
      @foreach($grades as $grade)
      <div class="bg-white p-5 rounded-2xl shadow-md border border border-gray-200">
        <!--学年タイトル-->
        <h5 class="text-center mb-4">
            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold bg-teal-200">
                {{ $grade->name }}
            </span>
        </h5>

        <!-- 授業リスト -->
        <ul class="space-y-3">
        @php
            $classes = $curriculums[$grade->id] ?? collect([]);
            // 現在の学年以下は有効、それより上は非活性
            $isActive = $grade->id <= $currentGrade->id;
        @endphp
            
        @foreach($classes as $class)
            @php
               $done = $progress[$class->id]->clear_flg ?? false;
            @endphp

           <li class="flex items-center justify-between">
              @if($isActive)
                 {{-- 現在の学年以下なのでリンク有効 --}}
                    <a href="{{ url('user/curriculums/'.$class->id) }}"
                       class="hover:underline {{ $done ? 'text-red-600 font-bold' : 'text-gray-800' }}">
                        @if($done) ✅ 受講済 @endif {{ $class->title }}
                    </a>

                 <!-- デモ用：受講トグルボタン -->
                <button class="ml-2 px-3 py-1 text-sm toggle-btn
                               {{ $done ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700' }}"
                         data-id="{{ $class->id }}">
                    {{ $done ? '未受講に戻す' : '受講しました' }}
                 </button>
                @else
                   {{-- 未来の学年なので非活性 --}}
                   <span class="text-gray-400">{{ $class->title }}</span>
                @endif 
           </li>
         @endforeach
        </ul>
      </div>
     @endforeach
   </div>

</div>

{{-- jQuery 読み込み&トグル処理 --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(function(){
        $(".toggle-btn").click(function(){
            let curriculumId = $(this).data("id");

            $.post("{{ route('progress.toggle') }}", {
                curriculum_id: curriculumId,
                _token: "{{ csrf_token() }}"
            }, function(res){
                if(res.status === 'success'){
                    location.reload(); //ページ更新で反映
                }
            });
        });
    });
</script>
@endsection
