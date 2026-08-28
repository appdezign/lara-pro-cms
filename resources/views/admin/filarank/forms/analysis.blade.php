@php
    /** @var list<\Usamamuneerchaudhary\FilaRank\Keyphrase\KeyphraseResult> $keyphrases */
    use Usamamuneerchaudhary\FilaRank\Analysis\Status;

    $dotClass = fn (Status $status): string => match ($status) {
        Status::Good => 'filarank-dot--success',
        Status::Ok => 'filarank-dot--warning',
        Status::Bad => 'filarank-dot--danger',
    };

    $scorePillClass = fn (?int $score): string => match (true) {
        $score === null => 'filarank-score-pill--gray',
        $score >= 80 => 'filarank-score-pill--success',
        $score >= 50 => 'filarank-score-pill--warning',
        default => 'filarank-score-pill--danger',
    };

    $scoreTextClass = fn (?int $score): string => match (true) {
        $score === null => 'filarank-score-text--gray',
        $score >= 80 => 'filarank-score-text--success',
        $score >= 50 => 'filarank-score-text--warning',
        default => 'filarank-score-text--danger',
    };

    $progressBarClass = fn (?int $score): string => match (true) {
        $score === null => 'filarank-progress-bar--gray',
        $score >= 80 => 'filarank-progress-bar--success',
        $score >= 50 => 'filarank-progress-bar--warning',
        default => 'filarank-progress-bar--danger',
    };

    $primary = collect($keyphrases)->firstWhere('isPrimary', true);
    $related = collect($keyphrases)->where('isPrimary', false);
@endphp

<div class="filarank-analysis">
    @if ($primary)
        @php $report = $primary->report; @endphp

        <div class="filarank-analysis-header">
            <span class="filarank-analysis-heading">
                {{ __('filarank::filarank.overall_score') }}
            </span>
            <span @class(['filarank-score-pill', $scorePillClass($report->score())])>
                {{ $report->score() === null ? '—' : $report->score() . ' / 100' }}
            </span>
            <span class="filarank-muted">“{{ $primary->keyphrase }}”</span>
        </div>

        @foreach ([
            __('filarank::filarank.group_seo') => [$report->seo(), $report->seoScore()],
            __('filarank::filarank.group_readability') => [$report->readability(), $report->readabilityScore()],
        ] as $label => [$results, $score])
            @continue(empty($results))

            @php
                $issues = collect($results)->filter(fn ($r) => $r->status !== Status::Good);
                $passed = collect($results)->filter(fn ($r) => $r->status === Status::Good);
            @endphp

            <div class="filarank-analysis-group">
                <div class="filarank-analysis-group-header">
                    <span class="filarank-analysis-heading">{{ $label }}</span>
                    <span @class(['text-xs font-semibold', $scoreTextClass($score)])>
                        {{ $score === null ? '' : $score . ' / 100' }}
                    </span>
                </div>

                @if ($score !== null)
                    <div class="filarank-progress">
                        <div
                            @class(['filarank-progress-bar', $progressBarClass($score)])
                            style="width: {{ min(100, max(0, $score)) }}%"
                        ></div>
                    </div>
                @endif

                @if ($issues->isNotEmpty())
                    <ul class="filarank-check-list">
                        @foreach ($issues as $result)
                            <li class="filarank-check-item">
                                <span @class(['filarank-dot', $dotClass($result->status)])></span>
                                <span>{{ $result->message }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if ($passed->isNotEmpty())
		            <ul class="filarank-check-list" style="margin-top: 1.5rem">
			            @foreach ($passed as $result)
				            <li class="filarank-check-item filarank-check-item--muted">
					            <span class="filarank-dot filarank-dot--success"></span>
					            <span>{{ $result->message }}</span>
				            </li>
			            @endforeach
		            </ul>
                @endif
            </div>
        @endforeach
    @else
        <p class="filarank-muted">{{ __('filarank::filarank.no_keyword') }}</p>
    @endif

    @if ($related->isNotEmpty())
        <div class="filarank-analysis-group">
            <div class="filarank-analysis-heading" style="margin-bottom: 0.5rem">
                {{ __('filarank::filarank.related_keyphrases') }}
            </div>
            <ul class="filarank-check-list">
                @foreach ($related as $kp)
                    <li class="filarank-list-item-row">
                        <span class="filarank-check-item">“{{ $kp->keyphrase }}”</span>
                        <span @class(['filarank-score-pill', $scorePillClass($kp->score())])>
                            {{ $kp->score() === null ? __('filarank::filarank.not_evaluated') : $kp->score() . ' / 100' }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
