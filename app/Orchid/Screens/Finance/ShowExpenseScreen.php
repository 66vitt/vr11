<?php

namespace App\Orchid\Screens\Finance;

use App\Actions\FinanceCreateAction;
use App\Http\Requests\ConfirmOrderRequest;
use App\Models\Client;
use App\Models\Expense;
use App\Models\Finance;
use App\Models\Order;
use App\Models\OrderPoint;
use App\Models\Point;
use App\Models\Truck;
use App\Models\User;
use App\View\Components\ImageComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Coords;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Repository;
use Orchid\Screen\Screen;
use Orchid\Screen\Sight;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ShowExpenseScreen extends Screen
{
    public $expense;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Expense $expense): iterable
    {
        return [
            'expense' => $expense,
            'attachments' => $expense->image,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Просмотр расхода';
    }


    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make('Назад')
                ->type(Color::LINK)
                ->route('expenses')
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
//        $attachments = $this->expense->image;
//        dd($this->expense->image);
        return [
            Layout::legend('expense', [
                Sight::make('id'),
                Sight::make('created_at', 'Дата'),
                Sight::make('Пользователь')
                    ->render(function(Expense $expense){
                        return User::find($expense['user_id'])->name;
                    }),
                Sight::make('sum', 'Сумма'),
            ]),
            Layout::component(ImageComponent::class)

        ];
    }

}
