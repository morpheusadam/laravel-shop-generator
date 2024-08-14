@extends('install.layout')

@section('content')
    @include('install.requirements')
    @include('install.permissions')
    @include('install.configuration')
    @include('install.complete')

    <footer class="footer d-flex justify-content-end" v-if="!appInstalled">
        <button
            v-cloak
            v-if="isShowPrev"
            type="button"
            class="btn btn-light"
            :disabled="isPrevDisabled"
            @click="prevStep"
        >
            Back
        </button>

        <button
            v-cloak
            v-if="step !== 4"
            type="button"
            class="btn btn-primary"
            :class="{ 'btn-loading': formSubmitting }"
            :disabled="isNextDisabled"
            @click="nextStep"
            v-text="step === 3 ? 'Install' : 'Next'"
        >
        </button>
    </footer>
@endsection
