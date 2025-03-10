@extends('layouts/layoutMaster')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('no-permiso'))
            alert('{{ session('no-permiso') }}');
        @endif
    });
</script>