-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql112.epizy.com
-- Tempo de geração: 12/04/2022 às 22:47
-- Versão do servidor: 10.3.27-MariaDB
-- Versão do PHP: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `epiz_31274701_fichas`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `armas`
--

CREATE TABLE `armas` (
  `id` int(11) NOT NULL,
  `id_ficha` int(255) DEFAULT NULL,
  `arma` mediumtext DEFAULT NULL,
  `tipo` mediumtext DEFAULT NULL,
  `dado` varchar(3) DEFAULT 'for',
  `ataque` int(3) DEFAULT NULL,
  `alcance` mediumtext DEFAULT NULL,
  `dano` mediumtext DEFAULT NULL,
  `critico` mediumtext DEFAULT NULL,
  `recarga` mediumtext DEFAULT NULL,
  `especial` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fichas_npc`
--

CREATE TABLE `fichas_npc` (
  `id` int(11) NOT NULL,
  `missao` int(11) DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `nex` tinyint(2) DEFAULT 0,
  `forca` tinyint(1) DEFAULT 0,
  `agilidade` tinyint(1) DEFAULT 0,
  `inteligencia` tinyint(1) DEFAULT 0,
  `presenca` tinyint(1) DEFAULT 0,
  `vigor` tinyint(1) DEFAULT 0,
  `pv` tinyint(3) DEFAULT 1,
  `pva` tinyint(3) DEFAULT 1,
  `san` tinyint(3) DEFAULT 1,
  `sana` tinyint(3) DEFAULT 1,
  `pe` tinyint(3) DEFAULT 1,
  `pea` tinyint(3) DEFAULT 1,
  `morrendo` tinyint(1) DEFAULT 0,
  `enlouquecendo` tinyint(1) DEFAULT 0,
  `passiva` tinyint(3) DEFAULT 0,
  `bloqueio` tinyint(3) DEFAULT 0,
  `esquiva` tinyint(3) DEFAULT 0,
  `mental` tinyint(2) DEFAULT 0,
  `sangue` tinyint(2) DEFAULT 0,
  `morte` tinyint(2) DEFAULT 0,
  `conhecimento` tinyint(2) DEFAULT 0,
  `energia` tinyint(2) DEFAULT 0,
  `fisica` tinyint(2) DEFAULT 0,
  `balistica` tinyint(2) DEFAULT 0,
  `atletismo` tinyint(2) DEFAULT 0,
  `atualidade` tinyint(2) DEFAULT 0,
  `ciencia` tinyint(2) DEFAULT 0,
  `diplomacia` tinyint(2) DEFAULT 0,
  `enganacao` tinyint(2) DEFAULT 0,
  `fortitude` tinyint(2) DEFAULT 0,
  `furtividade` tinyint(2) DEFAULT 0,
  `intimidacao` tinyint(2) DEFAULT 0,
  `intuicao` tinyint(2) DEFAULT 0,
  `investigacao` tinyint(2) DEFAULT 0,
  `luta` tinyint(2) DEFAULT 0,
  `medicina` tinyint(2) DEFAULT 0,
  `ocultismo` tinyint(2) DEFAULT 0,
  `percepcao` tinyint(2) DEFAULT 0,
  `pilotagem` tinyint(2) DEFAULT 0,
  `pontaria` tinyint(2) DEFAULT 0,
  `prestidigitacao` tinyint(2) DEFAULT 0,
  `profissao` tinyint(2) DEFAULT 0,
  `reflexos` tinyint(2) DEFAULT 0,
  `religiao` tinyint(2) DEFAULT 0,
  `tatica` tinyint(2) DEFAULT 0,
  `tecnologia` tinyint(2) DEFAULT 0,
  `vontade` tinyint(2) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `fichas_personagem`
--

CREATE TABLE `fichas_personagem` (
  `id` int(11) NOT NULL,
  `public` tinyint(1) DEFAULT 1,
  `usuario` int(255) DEFAULT NULL,
  `nome` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `origem` tinyint(2) DEFAULT NULL,
  `classe` tinyint(2) DEFAULT NULL,
  `trilha` tinyint(2) DEFAULT NULL,
  `nex` tinyint(3) DEFAULT NULL,
  `patente` tinyint(1) DEFAULT NULL,
  `idade` tinyint(2) DEFAULT NULL,
  `local` varchar(50) DEFAULT NULL,
  `historia` text DEFAULT NULL,
  `forca` tinyint(2) DEFAULT NULL,
  `agilidade` tinyint(2) DEFAULT NULL,
  `inteligencia` tinyint(2) DEFAULT NULL,
  `presenca` tinyint(2) DEFAULT NULL,
  `vigor` tinyint(2) DEFAULT NULL,
  `pv` tinyint(3) DEFAULT NULL,
  `pva` tinyint(3) DEFAULT NULL,
  `san` tinyint(3) DEFAULT NULL,
  `sana` tinyint(3) DEFAULT NULL,
  `pe` tinyint(3) DEFAULT NULL,
  `pea` tinyint(3) DEFAULT NULL,
  `morrendo` tinyint(1) DEFAULT NULL,
  `enlouquecendo` tinyint(1) DEFAULT NULL,
  `passiva` tinyint(3) DEFAULT NULL,
  `bloqueio` tinyint(3) DEFAULT NULL,
  `esquiva` tinyint(3) DEFAULT NULL,
  `mental` tinyint(2) DEFAULT NULL,
  `sangue` tinyint(2) DEFAULT NULL,
  `morte` tinyint(2) DEFAULT NULL,
  `energia` tinyint(2) DEFAULT NULL,
  `conhecimento` tinyint(2) DEFAULT NULL,
  `fisica` tinyint(2) DEFAULT NULL,
  `balistica` tinyint(2) DEFAULT NULL,
  `atletismo` tinyint(2) NOT NULL DEFAULT 0,
  `atualidades` tinyint(2) NOT NULL DEFAULT 0,
  `ciencia` tinyint(2) NOT NULL DEFAULT 0,
  `diplomacia` tinyint(2) NOT NULL DEFAULT 0,
  `enganacao` tinyint(2) NOT NULL DEFAULT 0,
  `fortitude` tinyint(2) NOT NULL DEFAULT 0,
  `furtividade` tinyint(2) NOT NULL DEFAULT 0,
  `intimidacao` tinyint(2) NOT NULL DEFAULT 0,
  `intuicao` tinyint(2) NOT NULL DEFAULT 0,
  `investigacao` tinyint(2) NOT NULL DEFAULT 0,
  `luta` tinyint(2) NOT NULL DEFAULT 0,
  `medicina` tinyint(2) NOT NULL DEFAULT 0,
  `ocultismo` tinyint(2) NOT NULL DEFAULT 0,
  `percepcao` tinyint(2) NOT NULL DEFAULT 0,
  `pilotagem` tinyint(2) NOT NULL DEFAULT 0,
  `pontaria` tinyint(2) NOT NULL DEFAULT 0,
  `prestidigitacao` tinyint(2) NOT NULL DEFAULT 0,
  `profissao` tinyint(2) NOT NULL DEFAULT 0,
  `reflexos` tinyint(2) NOT NULL DEFAULT 0,
  `religiao` tinyint(2) NOT NULL DEFAULT 0,
  `tatica` tinyint(2) NOT NULL DEFAULT 0,
  `tecnologia` tinyint(2) NOT NULL DEFAULT 0,
  `vontade` tinyint(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `habilidades`
--

CREATE TABLE `habilidades` (
  `id` int(255) NOT NULL,
  `id_ficha` int(255) DEFAULT NULL,
  `nome` mediumtext DEFAULT NULL,
  `descricao` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `iniciativas`
--

CREATE TABLE `iniciativas` (
  `id` int(255) NOT NULL,
  `id_missao` int(255) DEFAULT NULL,
  `prioridade` int(2) DEFAULT 99,
  `nome` varchar(50) DEFAULT 'Jogador',
  `iniciativa` int(2) DEFAULT 0,
  `dano` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `inventario`
--

CREATE TABLE `inventario` (
  `id` int(11) NOT NULL,
  `id_ficha` int(255) DEFAULT NULL,
  `nome` mediumtext DEFAULT NULL,
  `descricao` mediumtext DEFAULT NULL,
  `quantidade` tinyint(2) DEFAULT 0,
  `espaco` int(2) DEFAULT NULL,
  `prestigio` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `ligacoes`
--

CREATE TABLE `ligacoes` (
  `id` int(255) NOT NULL,
  `id_missao` int(255) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `id_ficha` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `missoes`
--

CREATE TABLE `missoes` (
  `id` int(255) NOT NULL,
  `mestre` int(11) DEFAULT NULL,
  `nome` text DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `missao` int(11) DEFAULT NULL,
  `nome` varchar(30) DEFAULT NULL,
  `notas` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `proeficiencias`
--

CREATE TABLE `proeficiencias` (
  `id` int(255) NOT NULL,
  `id_ficha` int(255) DEFAULT NULL,
  `nome` mediumtext DEFAULT NULL,
  `descricao` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `rituais`
--

CREATE TABLE `rituais` (
  `id` int(11) NOT NULL,
  `id_ficha` int(11) DEFAULT NULL,
  `foto` varchar(300) DEFAULT '1',
  `nome` varchar(50) DEFAULT NULL,
  `circulo` varchar(15) DEFAULT NULL,
  `elemento` varchar(50) DEFAULT NULL,
  `conjuracao` varchar(100) DEFAULT NULL,
  `efeito` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `user_tokens`
--

CREATE TABLE `user_tokens` (
  `id` int(11) NOT NULL,
  `selector` varchar(255) NOT NULL,
  `hashed_validator` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expiry` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '// not created but invited// 1 created and exist',
  `login` varchar(100) DEFAULT NULL,
  `nome` varchar(20) DEFAULT NULL,
  `senha` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT 0,
  `elite` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `armas`
--
ALTER TABLE `armas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ficha` (`id_ficha`);

--
-- Índices de tabela `fichas_npc`
--
ALTER TABLE `fichas_npc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idmissao` (`missao`);

--
-- Índices de tabela `fichas_personagem`
--
ALTER TABLE `fichas_personagem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iddono` (`usuario`);

--
-- Índices de tabela `habilidades`
--
ALTER TABLE `habilidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ficha` (`id_ficha`);

--
-- Índices de tabela `iniciativas`
--
ALTER TABLE `iniciativas`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ficha` (`id_ficha`);

--
-- Índices de tabela `ligacoes`
--
ALTER TABLE `ligacoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_ficha` (`id_ficha`),
  ADD KEY `id_missao` (`id_missao`);

--
-- Índices de tabela `missoes`
--
ALTER TABLE `missoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mestre` (`mestre`);

--
-- Índices de tabela `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notasmissao` (`missao`);

--
-- Índices de tabela `proeficiencias`
--
ALTER TABLE `proeficiencias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ficha` (`id_ficha`);

--
-- Índices de tabela `rituais`
--
ALTER TABLE `rituais`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_ficha` (`id_ficha`);

--
-- Índices de tabela `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nome` (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `armas`
--
ALTER TABLE `armas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fichas_npc`
--
ALTER TABLE `fichas_npc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fichas_personagem`
--
ALTER TABLE `fichas_personagem`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `habilidades`
--
ALTER TABLE `habilidades`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `iniciativas`
--
ALTER TABLE `iniciativas`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ligacoes`
--
ALTER TABLE `ligacoes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `missoes`
--
ALTER TABLE `missoes`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `proeficiencias`
--
ALTER TABLE `proeficiencias`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rituais`
--
ALTER TABLE `rituais`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `user_tokens`
--
ALTER TABLE `user_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `armas`
--
ALTER TABLE `armas`
  ADD CONSTRAINT `armas_ibfk_1` FOREIGN KEY (`id_ficha`) REFERENCES `fichas_personagem` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `fichas_npc`
--
ALTER TABLE `fichas_npc`
  ADD CONSTRAINT `idmissao` FOREIGN KEY (`missao`) REFERENCES `missoes` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `fichas_personagem`
--
ALTER TABLE `fichas_personagem`
  ADD CONSTRAINT `fichas_personagem_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `habilidades`
--
ALTER TABLE `habilidades`
  ADD CONSTRAINT `habilidades_ibfk_1` FOREIGN KEY (`id_ficha`) REFERENCES `fichas_personagem` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`id_ficha`) REFERENCES `fichas_personagem` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `ligacoes`
--
ALTER TABLE `ligacoes`
  ADD CONSTRAINT `ligacoes_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ligacoes_ibfk_2` FOREIGN KEY (`id_missao`) REFERENCES `missoes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ligacoes_ibfk_3` FOREIGN KEY (`id_ficha`) REFERENCES `fichas_personagem` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ligacoes_ibfk_4` FOREIGN KEY (`id_ficha`) REFERENCES `fichas_personagem` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ligacoes_ibfk_5` FOREIGN KEY (`id_missao`) REFERENCES `missoes` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `missoes`
--
ALTER TABLE `missoes`
  ADD CONSTRAINT `missoes_ibfk_1` FOREIGN KEY (`mestre`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `proeficiencias`
--
ALTER TABLE `proeficiencias`
  ADD CONSTRAINT `proeficiencias_ibfk_1` FOREIGN KEY (`id_ficha`) REFERENCES `fichas_personagem` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `rituais`
--
ALTER TABLE `rituais`
  ADD CONSTRAINT `rituais_ibfk_1` FOREIGN KEY (`id_ficha`) REFERENCES `fichas_personagem` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `user_tokens`
--
ALTER TABLE `user_tokens`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
