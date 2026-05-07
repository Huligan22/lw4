<?php

class OrderManager
{
    private array $orders = [];
    private int $lastId = 0;

    public function createOrder(float $amount): void
    {
        $this->lastId++;
        $newOrder = [
            'id' => $this->lastId,
            'amount' => $amount,
            'status' => 'новый'
        ];
        $this->orders[$this->lastId] = $newOrder;
    }

    public function setStatus(int $id, string $status): void
    {
        if (!isset($this->orders[$id])) {
            throw new Exception("Заказ с ID {$id} не найден.");
        }
        $validStatuses = ['новый', 'в работе', 'завершенный'];
        if (!in_array($status, $validStatuses)) {
            throw new Exception("Недопустимый статус: {$status}");
        }
        $this->orders[$id]['status'] = $status;
    }

    public function getOrdersByStatus(string $status): array
    {
        return array_values(array_filter(
            $this->orders,
            fn(array $order) => $order['status'] === $status
        ));
    }

    public function showAllOrders(): void
    {
        foreach ($this->orders as $order) {
            printf(
                "ID: %d, Сумма: %.2f, Статус: %s\n",
                $order['id'],
                $order['amount'],
                $order['status']
            );
        }
    }
}

$manager = new OrderManager();

$manager->createOrder(1000.00);
$manager->createOrder(500.00);
$manager->createOrder(2000.00);

$manager->showAllOrders();

$manager->setStatus(2, 'в работе');

$newOrders = $manager->getOrdersByStatus('новый');
$workingOrders = $manager->getOrdersByStatus('в работе');

printf("\nЗаказы со статусом 'новый':\n");
print_r($newOrders);

printf("\nЗаказы со статусом 'в работе':\n");
print_r($workingOrders);
