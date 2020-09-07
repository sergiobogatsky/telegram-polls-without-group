@extends('layouts/app')

@section('content')
    <div class="container">
        <Index></Index>
    </div>
@endsection
<script>
    import Index from "../../resources/js/pages/Index";
    export default {
        components: {Index}
    }
</script>
