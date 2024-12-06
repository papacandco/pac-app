@extends('layouts.app', ['active' => 'transaction', 'navbar_with_shadow' => true])

@section('title', __('user.transaction_titlte'))

@section('content')
@include('user.partials.header', ['active' => 'transaction'])
<section class="container" style="margin-top: -20px; margin-bottom: 10px; padding: 20px;">
  <div class="row">
    <div class="col-sm-12">
      <h3>{{ __('user.transaction_title') }} ({{ $user->unreadNotifications()->count() }})</h3>
      <table id="users" class="table row shadow-sm rounded table-responsive table-hover">
        <thead>
          <tr>
            <th>Labelle</th>
            <th>Montant</th>
            <th>Provider</th>
            <th>Efféctué le</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @forelse($transactions as $transaction)
          <tr>
            <td><b>{{ $transaction->label }}</b></td>
            <td><b>{{ strtoupper($transaction->amount) }} {{ $transaction->extras->currency }}</b></td>
            <td><b>{{ strtoupper($transaction->provider) }}</b></td>
            <td>{{ $transaction->created_at->format('d/m/Y à H:i:s') }}</td>
            <td><a target="_blank" href="{{ route('user.transaction.invoice', ['transaction' => $transaction->id]) }}">Voir la facture</a></td>
          </tr>
          @empty
          <tr>
            <td colspan="8">
              <div class="empty-data">Aucune transaction enregistré !</div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</section>

@include("user.modal.delete-notification")
@include("user.modal.read-notification")
@endsection

