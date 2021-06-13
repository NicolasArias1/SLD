<style>
    .spinner-container {
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: 99999;
        background-color: darkgray;
        opacity: 65%;
        display: none;
    }

    .spinner {
        width: 200px;
        height: 200px;
        position: absolute;
        margin: auto;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
</style>

<div id="spinner-container" class="spinner-container">
    <div id="spinner" class="spinner-grow text-warning spinner" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>