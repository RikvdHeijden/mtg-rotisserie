@extends('layout')

@section('content')
    <h1>Rotisserie draft tool</h1>
    <p>
        This tool was created by <a href="https://github.com/RikvdHeijden" target="_blank" rel="noopener noreferrer">me</a>
        after watching <a href="https://www.youtube.com/watch?v=JQIMZvAXQLg" target="_blank" rel="noopener noreferrer">this</a>
        LoadingReadyRun Friday Night Paper Fight. I greatly enjoyed the content and gameplay; but I thought the drafting
        solution they chose was a little cumbersome. So, since I was about to start a three-week vacation from work, I figured
        I'd take on the project of making a tool to speed up the drafting process in the future.
    </p>
    <p>
        Three weeks later this is the result. Since I have a girlfriend and a baby this represents just a few nights of
        actual work done on the tool itself, so expect bugs and things to not work perfectly, but don't fret. This tool is
        completely free to use and open source, so you can make your own improvements right
        <a href="https://github.com/RikvdHeijden/mtg-rotisserie" target="_blank" rel="noopener noreferrer">here</a>.
    </p>
    <p>
        Anyway; enough about me, you can:
    </p>
    <a href="/draft/create" class="btn btn-lg btn-outline-dark">Create a new draft room</a>
    <a href="/draft/join" class="btn btn-lg btn-outline-dark">Join an existing draft room</a>
@endsection
