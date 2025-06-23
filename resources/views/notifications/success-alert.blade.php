<div>
    {{-- modal popup success --}}
    <div style="
                    position: fixed;
                    top: 30px;
                    left: 60%;
                    transform: translateX(-50%);
                    z-index: 1050;
                    width: 50%;
                    transition: all 0.2s ease-in-out;
                "
        class="bg-white border-bottom-0 border-right-0 border-left-0 py-4 border-success shadow shadow-md mx-auto alert alert-dismissible fade show relative"
        role="alert">
        <strong class="text-success">Berhasil ! </strong> {{ $message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</div>
