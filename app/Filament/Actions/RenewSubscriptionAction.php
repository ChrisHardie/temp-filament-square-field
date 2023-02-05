<?php

namespace App\Filament\Actions;

use App\Forms\Components\SquarePayment;
use App\Helpers\SquareHelper;
use App\Helpers\SubscriptionPricingHelper;
use App\Models\Contact;
use App\Models\Subscription;
use Closure;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Notifications\Notification;
use Filament\Support\Actions\Modal\Actions\Action as ModalAction;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\HtmlString;

class RenewSubscriptionAction extends Action
{
    public static function make(?string $name = 'create_renewal'): static
    {
        return parent::make($name);
    }

    public function setUp(): void
    {
        parent::setUp();

        $this
            ->modalHeading('Renew Subscription')
            ->modalButton('Renew')
            ->icon('heroicon-o-refresh');
    }

    public function getMountUsing(): Closure
    {
        return static function (\Filament\Forms\ComponentContainer $form, Subscription $record) {
            $sub = $record;

            if (! empty($sub)) {
                $form->fill([
                    'subscriptionId' => $sub->id,
                    'renewalPrice' => $sub->amount,
                    'paymentMethod' => 'check',
                ]);
            }
        };
    }

    public function getAction(): ?Closure
    {
        return static function (array $data, Subscription $record, $action): void {
            Log::debug(print_r($data, true));

            if (! empty($data['squarePaymentID'])) {
                Notification::make()
                    ->title('Subscription renewed successfully')
                    ->success()
                    ->send();
            } else {
                Notification::make()
                    ->title('Subscription renewal failed')
                    ->danger()
                    ->send();
            }
        };
    }

    public function getFormSchema(): array
    {
        return [
            \Filament\Forms\Components\Hidden::make('subscriptionId'),
            \Filament\Forms\Components\Grid::make([
                'default' => 1,
                'sm' => 1,
                'md' => 2,
                'lg' => 2,
                'xl' => 2,
                '2xl' => 2,
            ])->schema([
                \Filament\Forms\Components\TextInput::make('renewalPrice')
                    ->mask(
                        fn (Mask $mask) => $mask
                            ->money(prefix: '$', thousandsSeparator: ',', decimalPlaces: 2)
                            ->range()
                            ->from(0)
                            ->to(100)
                            ->maxValue(100)
                            ->minValue(0)
                    )
                    ->required()
                    ->reactive()
                    ->disabled(static fn (Closure $get): bool => 'card' === $get('paymentMethod')),
                \Filament\Forms\Components\Select::make('paymentMethod')
                    ->options([
                        'check' => 'Check',
                        'cash' => 'Cash',
                        'card' => 'Credit Card',
                        'other' => 'Other',
                    ])->required()->reactive(),
//                SquarePayment::make('squarePayment')
//                    ->visible(static fn (Closure $get): bool => 'card' === $get('paymentMethod'))
//                    ->disableLabel()
//                    ->setCurrentPrice(fn ($get) => $get('renewalPrice'))
//                    ->reactive()
//                    ->columnSpan(2),
            ])
        ];
    }
}
