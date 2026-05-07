<?php

class OrderManager
{
    protected $orders = [];
    protected $lastId = 0;
    public function createOrder(float $amount): void
    {
        $this->lastId++;
        
        $order = [
            'id' => $this->lastId,
            'amount' => $amount,
            'status' => 'новый'
        ];
        
        $this->orders[$this->lastId] = $order;
    }
    public function setStatus(int $id, string $status): void
    {
        if (!isset($this->orders[$id])) {
            throw new Exception("Заказ с ID {$id} не найден");
        }
        
        $allowedStatuses = ['новый', 'в работе', 'завершенный'];
        
        if (!in_array($status, $allowedStatuses)) {
            throw new Exception("Недопустимый статус: {$status}");
        }
        
        $this->orders[$id]['status'] = $status;
    }
    public function getOrdersByStatus(string $status): array
    {
        $filteredOrders = [];
        
        foreach ($this->orders as $order) {
            if ($order['status'] === $status) {
                $filteredOrders[] = $order;
            }
        }
        
        return $filteredOrders;
    }
    public function showAllOrders(): void
    {
        foreach ($this->orders as $order) {
            echo "ID: {$order['id']} Сумма: {$order['amount']} Статус: {$order['status']}\n";
        }
    }
}
$manager = new OrderManager();

$manager->createOrder(1000);
$manager->createOrder(500); 
$manager->createOrder(2000);

$manager->showAllOrders();

echo "\nМеняем статус заказа №2 на \"в работе\"\n";
$manager->setStatus(2, 'в работе');

echo "\nПолучаем заказы со статусом \"новый\":\n";
print_r($manager->getOrdersByStatus('новый'));

echo "\nПолучаем заказы со статусом \"в работе\":\n";
print_r($manager->getOrdersByStatus('в работе'));