try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("DELETE FROM triagem WHERE id_paciente = ?");
    $stmt->execute([$id_paciente]);

    $stmt = $pdo->prepare("DELETE FROM paciente WHERE id = ?");
    $stmt->execute([$id_paciente]);

    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Erro ao apagar paciente: " . $e->getMessage();
}
