<div>
    @if($statistics->count() > 0)
        <!-- Statistics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-8">
            @foreach($statistics as $index => $statistic)
                <div x-data="{
                        shown: false,
                        currentPercentage: 0,
                        targetPercentage: {{ $statistic->percentage }},
                        animateCounter() {
                            if (this.currentPercentage < this.targetPercentage) {
                                const increment = Math.ceil(this.targetPercentage / 50);
                                const interval = setInterval(() => {
                                    this.currentPercentage += increment;
                                    if (this.currentPercentage >= this.targetPercentage) {
                                        this.currentPercentage = this.targetPercentage;
                                        clearInterval(interval);
                                    }
                                }, 30);
                            }
                        }
                     }"
                     x-intersect.once="shown = true; animateCounter()"
                     class="text-center transition-all duration-700 transform"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-10'"
                     style="transition-delay: {{ $index * 100 }}ms;">

                    <!-- Icon Container -->
                    <div class="flex justify-center mb-4">
                        <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center
                                    transform transition-all duration-300 hover:scale-110 hover:bg-white/30">
                            <i class="fas {{ $statistic->icon ?? 'fa-chart-line' }} text-3xl text-white"></i>
                        </div>
                    </div>

                    <!-- Percentage with Animation -->
                    <div class="mb-3">
                        <span class="text-5xl font-bold text-white" x-text="currentPercentage + '%'">
                            0%
                        </span>
                    </div>

                    <!-- Label -->
                    <h3 class="text-lg font-semibold text-white/90">
                        {{ $statistic->label }}
                    </h3>

                    <!-- Progress Bar (Optional Visual Enhancement) -->
                    <div class="mt-4 h-1.5 bg-white/20 rounded-full overflow-hidden">
                        <div class="h-full bg-white rounded-full transition-all duration-1000 ease-out"
                             :style="`width: ${shown ? currentPercentage : 0}%`"
                             style="transition-delay: {{ $index * 100 }}ms;">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State (only visible in development) -->
        <div class="text-center py-12">
            <i class="fas fa-chart-bar text-6xl text-white/30 mb-4"></i>
            <p class="text-white/70 text-lg">No statistics available at the moment.</p>
        </div>
    @endif
</div>
