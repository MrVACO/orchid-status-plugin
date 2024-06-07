<svg xmlns="http://www.w3.org/2000/svg"
     fill="{{ $status->color }}"
     viewBox="0 0 24 24"
     width="24"
     height="24"
     class="inline-block"
>
    <circle cx="12" cy="12" r="4" />
</svg>

<span
    style="color: {{ $status->color }}; font-size: 105%"
>
    {{ $status->name }}
</span>
