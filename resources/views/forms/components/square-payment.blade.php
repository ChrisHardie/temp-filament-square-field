<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-action="$getHintAction()"
    :hint-color="$getHintColor()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div x-data="squarePaymentComponent({
            state: $wire.{{ $applyStateBindingModifiers('entangle(\'' . $getStatePath() . '\')') }},
        })"
         x-init="launchSquareForm('{{ config('wwn.integrations.square.app_id') }}', '{{ config('wwn.integrations.square.location_id') }}')"
    >
        <div id="square-payment-wrapper">
            <form id="payment-form">
                <div id="card-container" wire:ignore></div>
                <button id="card-button" type="button"
                        @click.prevent="handleCardButtonClicked( {{ $getCurrentPrice() }}, {{  $getRecord()->id }} )"
                >Charge Credit Card ${{ number_format($getCurrentPrice(), 2) }}</button>
            </form>
            <div id="payment-status-container"></div>
            <div>
                <p>Value of field state:</p>
                <div x-html="state"></div>
            </div>
        </div>
    </div>
</x-dynamic-component>
