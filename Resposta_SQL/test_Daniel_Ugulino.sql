 Select 
        bc.nome as nome_banco,
        cov.verba as verba,
        MAX(ct.data_inclusao) as data_inclusao_newest,
        MIN(ct.data_inclusao) as data_inclusao_oldest,
        SUM(ct.valor) as valor_total
    From
        Tb_contrato as ct
        Join Tb_convenio_servico as cns ON ct.convenio_servico = cns.codigo
        Join Tb_convenio as cov ON cns.convenio = cov.codigo
        Join Tb_banco as bc ON cov.banco = bc.codigo
    GROUP BY 
        bc.nome, cov.verba
    ORDER BY 
        bc.nome, cov.verba;