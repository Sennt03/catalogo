<style>
    /* ── Falling stars: subtle, slow, elegant ─────────────── */
    @keyframes sf-a {
        0%   { transform: translateY(0) rotate(0deg);     opacity: 0; }
        8%   { opacity: .20; }
        92%  { opacity: .20; }
        100% { transform: translateY(108vh) rotate(180deg); opacity: 0; }
    }
    @keyframes sf-b {
        0%   { transform: translateY(0) rotate(15deg);    opacity: 0; }
        8%   { opacity: .14; }
        92%  { opacity: .14; }
        100% { transform: translateY(108vh) rotate(-90deg); opacity: 0; }
    }
    @keyframes sf-c {
        0%   { transform: translateY(0) rotate(-10deg);   opacity: 0; }
        8%   { opacity: .10; }
        92%  { opacity: .10; }
        100% { transform: translateY(108vh) rotate(220deg); opacity: 0; }
    }
    @keyframes sf-dot {
        0%   { transform: translateY(0) scale(1);    opacity: 0; }
        10%  { opacity: .16; }
        90%  { opacity: .16; }
        100% { transform: translateY(108vh) scale(.5); opacity: 0; }
    }
    #star-rain > * { position: absolute; pointer-events: none; }
</style>

{{-- z-index:1 → above the dot-grid background, but the page wrapper is z-index:2 so stars stay behind content --}}
<div id="star-rain"
     style="position:fixed;inset:0;overflow:hidden;pointer-events:none;z-index:1"
     aria-hidden="true">

    @php
        $p = 'M10 0l1.8 8.2L20 10l-8.2 1.8L10 20l-1.8-8.2L0 10l8.2-1.8Z';
        $c = ['#f9a8d4','#f472b6','#fbcfe8','#fce7f3','#f9a8d4','#fbcfe8','#f472b6'];
        /*  [left%, size, dur(s), delay(s), anim, dot?]  – durations 22-46s for a slow elegant drift */
        $st = [
            [ 2, 5, 28,   0, 'a', false], [ 8, 3, 35, -12, 'b', false],
            [14, 6, 24,  -5, 'a', true ], [20, 4, 40, -28, 'c', false],
            [27, 3, 32,  -9, 'b', false], [33, 7, 26, -20, 'a', false],
            [39, 4, 44,  -2, 'c', true ], [45, 3, 30, -35, 'b', false],
            [51, 6, 38, -14, 'a', false], [57, 3, 25, -26, 'c', false],
            [63, 5, 33,  -7, 'b', true ], [69, 4, 42, -40, 'a', false],
            [75, 3, 29, -18, 'c', false], [81, 6, 36, -11, 'b', false],
            [87, 4, 31, -32, 'a', true ], [93, 3, 46, -22, 'c', false],
            [98, 5, 27,  -4, 'b', false], [ 5, 4, 45, -25, 'c', false],
            [11, 6, 33,  -8, 'a', true ], [17, 3, 37, -16, 'b', false],
            [23, 5, 25, -38, 'a', false], [30, 4, 43, -11, 'c', false],
            [36, 3, 30, -30, 'b', true ], [42, 6, 34,  -5, 'a', false],
            [48, 4, 40, -19, 'c', false], [54, 3, 28, -33, 'b', false],
            [60, 5, 38, -13, 'a', true ], [66, 4, 32, -24, 'c', false],
            [72, 3, 45,  -1, 'b', false], [78, 6, 27, -37, 'a', false],
            [84, 4, 35, -17, 'c', true ], [90, 3, 42, -10, 'b', false],
            [96, 5, 29, -29, 'a', false], [25, 3, 33, -42, 'c', false],
            [50, 4, 38,  -6, 'b', true ], [74, 3, 28, -21, 'a', false],
            [15, 5, 44, -15, 'c', false], [85, 3, 35, -31, 'b', false],
        ];
    @endphp

    @foreach($st as $i => $s)
        @php [$l,$sz,$d,$dl,$an,$dot] = $s; $col = $c[$i % count($c)]; @endphp
        @if($dot)
            <div style="left:{{$l}}%;top:-6px;width:{{$sz}}px;height:{{$sz}}px;border-radius:9999px;background:{{$col}};animation:sf-dot {{$d}}s linear {{$dl}}s infinite"></div>
        @else
            <svg style="left:{{$l}}%;top:-8px;width:{{$sz}}px;height:{{$sz}}px;color:{{$col}};animation:sf-{{$an}} {{$d}}s linear {{$dl}}s infinite" viewBox="0 0 20 20" fill="currentColor"><path d="{{$p}}"/></svg>
        @endif
    @endforeach

</div>
