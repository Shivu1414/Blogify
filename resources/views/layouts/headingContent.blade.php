<div class="flex items-center justify-between mb-4 pl-4">
    <div class="text-sm text-gray-500">
        @if($panel === 'dashboard')
            <span class="hover:text-blue-500 cursor-pointer">Dashboard</span>
            <span class="mx-2">/</span>
            <span class="text-gray-700">{{ $heading ?? '' }}</span>
        @endif
    </div>
</div>