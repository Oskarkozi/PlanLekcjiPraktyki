-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Lis 20, 2024 at 10:22 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dziennikdb`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klasy`
--

CREATE TABLE `klasy` (
  `Klasa_id` int(11) NOT NULL,
  `Klasa` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `klasy`
--

INSERT INTO `klasy` (`Klasa_id`, `Klasa`) VALUES
(1, '1a'),
(2, '1b'),
(3, '1c'),
(4, '1d'),
(5, '2a'),
(6, '2b'),
(7, '2c'),
(8, '2d'),
(9, '3a'),
(10, '3b'),
(11, '3c'),
(12, '3d'),
(13, '4a'),
(14, '4b'),
(15, '4c'),
(16, '4d'),
(17, '5a'),
(18, '5b'),
(19, '5c'),
(20, '5d'),
(21, '6n');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `nauczyciele`
--

CREATE TABLE `nauczyciele` (
  `Nauczyciel_id` int(11) NOT NULL,
  `Imie` char(50) NOT NULL,
  `Nazwisko` char(50) NOT NULL,
  `Profesja` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nauczyciele`
--

INSERT INTO `nauczyciele` (`Nauczyciel_id`, `Imie`, `Nazwisko`, `Profesja`) VALUES
(1, 'Jan', 'Kowalski', 'Matematyka'),
(2, 'Anna', 'Nowak', 'Fizyka'),
(3, 'Piotr', 'Wiśniewski', 'Chemia'),
(4, 'Katarzyna', 'Wójcik', 'Biologia'),
(5, 'Tomasz', 'Kozłowski', 'Historia'),
(6, 'Michał', 'Jankowski', 'Geografia'),
(7, 'Agnieszka', 'Mazur', 'Polski'),
(8, 'Marcin', 'Krawczyk', 'Wychowanie Fizyczne'),
(9, 'Monika', 'Kaczmarek', 'Informatyka'),
(10, 'Paweł', 'Pawlak', 'Angielski'),
(11, 'Ewa', 'Zalewska', 'Francuski'),
(12, 'Łukasz', 'Sobczak', 'Hiszpański'),
(13, 'Magdalena', 'Zając', 'Plastyka'),
(14, 'Adam', 'Król', 'Muzyka'),
(15, 'Dorota', 'Majewska', 'Fizyka'),
(16, 'Karol', 'Olszewski', 'Matematyka'),
(17, 'Barbara', 'Czarnecka', 'Polski'),
(18, 'Rafał', 'Sikora', 'Chemia'),
(19, 'Alicja', 'Domańska', 'Biologia'),
(20, 'Grzegorz', 'Piotrowski', 'Historia'),
(21, 'Joanna', 'Szymańska', 'Geografia'),
(22, 'Beata', 'Głowacka', 'Informatyka'),
(23, 'Mateusz', 'Woźniak', 'Matematyka'),
(24, 'Patrycja', 'Dudek', 'Polski'),
(25, 'Wojciech', 'Piekarski', 'Historia'),
(26, 'Natalia', 'Orłowska', 'Biologia'),
(27, 'Sebastian', 'Marciniak', 'Fizyka'),
(28, 'Sylwia', 'Bąk', 'Angielski'),
(29, 'Zbigniew', 'Ciesielski', 'Matematyka'),
(30, 'Iwona', 'Bednarek', 'Geografia');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `plan_lekcji`
--

CREATE TABLE `plan_lekcji` (
  `Lekcja_id` int(11) NOT NULL,
  `Numer_Lekcji` int(2) NOT NULL,
  `Dzien` tinyint(1) NOT NULL,
  `Klasa_id` int(11) DEFAULT NULL,
  `Sala_id` int(11) DEFAULT NULL,
  `Nauczyciel_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `plan_lekcji`
--

INSERT INTO `plan_lekcji` (`Lekcja_id`, `Numer_Lekcji`, `Dzien`, `Klasa_id`, `Sala_id`, `Nauczyciel_id`) VALUES
(1, 1, 1, 1, 1, 1),
(3, 1, 1, 2, 12, 18),
(4, 2, 1, 1, 8, 6);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sale`
--

CREATE TABLE `sale` (
  `Sala_id` int(11) NOT NULL,
  `Numer_Sali` int(11) NOT NULL,
  `Komputerowa` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale`
--

INSERT INTO `sale` (`Sala_id`, `Numer_Sali`, `Komputerowa`) VALUES
(1, 100, 0),
(2, 101, 0),
(3, 102, 0),
(4, 103, 0),
(5, 104, 0),
(6, 105, 0),
(7, 106, 0),
(8, 107, 1),
(9, 108, 1),
(10, 109, 1),
(11, 200, 0),
(12, 201, 0),
(13, 202, 0),
(14, 203, 0),
(15, 204, 0),
(16, 205, 0),
(17, 206, 0),
(18, 207, 1),
(19, 208, 1),
(20, 209, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `szczensliwy_numer`
--

CREATE TABLE `szczensliwy_numer` (
  `date` date NOT NULL,
  `lucky_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `szczensliwy_numer`
--

INSERT INTO `szczensliwy_numer` (`date`, `lucky_number`) VALUES
('2024-11-20', 10);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uczen`
--

CREATE TABLE `uczen` (
  `Uczen_id` int(11) NOT NULL,
  `Imie` varchar(50) NOT NULL,
  `Nazwisko` varchar(50) NOT NULL,
  `Klasa_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uczen`
--

INSERT INTO `uczen` (`Uczen_id`, `Imie`, `Nazwisko`, `Klasa_id`) VALUES
(1, 'Jan', 'Kowalski', 1),
(2, 'Anna', 'Nowak', 1),
(3, 'Piotr', 'Wiśniewski', 1),
(4, 'Katarzyna', 'Wójcik', 1),
(5, 'Tomasz', 'Kozłowski', 1),
(6, 'Michał', 'Jankowski', 1),
(7, 'Agnieszka', 'Mazur', 1),
(8, 'Marcin', 'Krawczyk', 1),
(9, 'Monika', 'Kaczmarek', 1),
(10, 'Paweł', 'Pawlak', 1),
(11, 'Ewa', 'Zalewska', 1),
(12, 'Łukasz', 'Sobczak', 1),
(13, 'Magdalena', 'Zając', 1),
(14, 'Adam', 'Król', 1),
(15, 'Dorota', 'Majewska', 1),
(16, 'Karol', 'Olszewski', 1),
(17, 'Barbara', 'Czarnecka', 1),
(18, 'Rafał', 'Sikora', 1),
(19, 'Alicja', 'Domańska', 1),
(20, 'Grzegorz', 'Piotrowski', 1),
(21, 'Joanna', 'Szymańska', 1),
(22, 'Natalia', 'Orłowska', 2),
(23, 'Sebastian', 'Marciniak', 2),
(24, 'Sylwia', 'Bąk', 2),
(25, 'Zbigniew', 'Ciesielski', 2),
(26, 'Iwona', 'Bednarek', 2),
(27, 'Jakub', 'Błaszczyk', 2),
(28, 'Alicja', 'Gajda', 2),
(29, 'Marek', 'Wrona', 2),
(30, 'Elżbieta', 'Urbaniak', 2),
(31, 'Krystyna', 'Kasprzak', 2),
(32, 'Jacek', 'Musiał', 2),
(33, 'Renata', 'Laskowska', 2),
(34, 'Tadeusz', 'Kępa', 2),
(35, 'Grażyna', 'Czajkowska', 2),
(36, 'Dawid', 'Sadowski', 2),
(37, 'Kinga', 'Urbaniak', 2),
(38, 'Mariusz', 'Brzozowski', 2),
(39, 'Izabela', 'Makowska', 2),
(40, 'Aleksandra', 'Wasilewska', 2),
(41, 'Zofia', 'Ostrowska', 2),
(42, 'Robert', 'Lis', 2),
(43, 'Janina', 'Pawlak', 2),
(44, 'Daniel', 'Chmielewski', 2),
(45, 'Karolina', 'Adamczyk', 2),
(46, 'Henryk', 'Cieślak', 3),
(47, 'Aldona', 'Lipska', 3),
(48, 'Włodzimierz', 'Majewski', 3),
(49, 'Danuta', 'Witkowska', 3),
(50, 'Ewelina', 'Malinowska', 3),
(51, 'Jan', 'Markowski', 3),
(52, 'Sylwester', 'Grzelak', 3),
(53, 'Adrian', 'Grabowski', 3),
(54, 'Marzena', 'Wróbel', 3),
(55, 'Roman', 'Orzechowski', 3),
(56, 'Julia', 'Ostrowska', 3),
(57, 'Natalia', 'Olejniczak', 3),
(58, 'Joanna', 'Żak', 3),
(59, 'Michał', 'Kołodziej', 3),
(60, 'Urszula', 'Szymańska', 3),
(61, 'Maciej', 'Borkowski', 3),
(62, 'Lidia', 'Stankiewicz', 3),
(63, 'Arkadiusz', 'Chmiel', 3),
(64, 'Eliza', 'Baran', 3),
(65, 'Alicja', 'Wieczorek', 3),
(66, 'Władysław', 'Matusiak', 4),
(67, 'Alicja', 'Lipska', 4),
(68, 'Szymon', 'Majchrzak', 4),
(69, 'Klaudia', 'Rogowska', 4),
(70, 'Krzysztof', 'Kowalik', 4),
(71, 'Barbara', 'Tomczak', 4),
(72, 'Eryk', 'Witkowski', 4),
(73, 'Paulina', 'Kuczyńska', 4),
(74, 'Łukasz', 'Barański', 4),
(75, 'Dominika', 'Kamińska', 4),
(76, 'Bartosz', 'Urban', 4),
(77, 'Marta', 'Sikora', 4),
(78, 'Karolina', 'Michałowska', 4),
(79, 'Jakub', 'Ratajczak', 4),
(80, 'Agata', 'Rybak', 4),
(81, 'Oliwia', 'Domańska', 4),
(82, 'Przemysław', 'Lewandowski', 4),
(83, 'Aleksander', 'Szulc', 4),
(84, 'Bożena', 'Lis', 4),
(85, 'Tomasz', 'Adamczyk', 4),
(86, 'Ireneusz', 'Kołodziej', 4),
(87, 'Marek', 'Wysocki', 4),
(88, 'Zuzanna', 'Duda', 4),
(89, 'Wojciech', 'Sobolewski', 5),
(90, 'Ewa', 'Chmiel', 5),
(91, 'Radosław', 'Wolski', 5),
(92, 'Julia', 'Lisowska', 5),
(93, 'Katarzyna', 'Maciejewska', 5),
(94, 'Bartosz', 'Duda', 5),
(95, 'Oliwia', 'Malinowska', 5),
(96, 'Tomasz', 'Kowalik', 5),
(97, 'Mateusz', 'Błaszczyk', 5),
(98, 'Daria', 'Lewandowska', 5),
(99, 'Patryk', 'Urbanek', 5),
(100, 'Emilia', 'Górska', 5),
(101, 'Adrian', 'Markiewicz', 5),
(102, 'Aneta', 'Sawicka', 5),
(103, 'Maciej', 'Adamczyk', 5),
(104, 'Gabriela', 'Nowicka', 5),
(105, 'Mikołaj', 'Pawlak', 5),
(106, 'Sandra', 'Sikora', 5),
(107, 'Sylwia', 'Czarnecka', 5),
(108, 'Dawid', 'Zalewski', 5),
(109, 'Kinga', 'Sowa', 5),
(110, 'Filip', 'Stępień', 5),
(111, 'Renata', 'Szymczak', 5),
(112, 'Konrad', 'Kubiak', 5),
(113, 'Paulina', 'Czajka', 5),
(114, 'Kamil', 'Sokołowski', 6),
(115, 'Aneta', 'Majewska', 6),
(116, 'Dariusz', 'Michalak', 6),
(117, 'Patrycja', 'Osińska', 6),
(118, 'Sebastian', 'Makowski', 6),
(119, 'Natalia', 'Tomczyk', 6),
(120, 'Igor', 'Wilk', 6),
(121, 'Edyta', 'Krawczyk', 6),
(122, 'Przemysław', 'Mazur', 6),
(123, 'Grażyna', 'Kołodziej', 6),
(124, 'Damian', 'Kaczmarek', 6),
(125, 'Justyna', 'Szczepańska', 6),
(126, 'Wioletta', 'Gajda', 6),
(127, 'Artur', 'Zalewski', 6),
(128, 'Kinga', 'Sowa', 6),
(129, 'Ryszard', 'Ostrowski', 6),
(130, 'Olga', 'Leszczyńska', 6),
(131, 'Adrian', 'Piotrowski', 6),
(132, 'Urszula', 'Włodarczyk', 6),
(133, 'Waldemar', 'Borkowski', 6),
(134, 'Maria', 'Piątek', 6),
(135, 'Henryk', 'Król', 6),
(136, 'Emilia', 'Bielecka', 7),
(137, 'Marta', 'Czarnecka', 7),
(138, 'Marcin', 'Kamiński', 7),
(139, 'Paulina', 'Nowicka', 7),
(140, 'Krzysztof', 'Kowalski', 7),
(141, 'Renata', 'Kopeć', 7),
(142, 'Filip', 'Janik', 7),
(143, 'Zofia', 'Szymczak', 7),
(144, 'Mateusz', 'Głowacki', 7),
(145, 'Szymon', 'Stankiewicz', 7),
(146, 'Beata', 'Kałuża', 7),
(147, 'Grzegorz', 'Gajewski', 7),
(148, 'Katarzyna', 'Grzelak', 7),
(149, 'Aleksandra', 'Urbańska', 7),
(150, 'Mariusz', 'Baran', 7),
(151, 'Marzena', 'Kubiak', 7),
(152, 'Rafał', 'Lisowski', 7),
(153, 'Andrzej', 'Marciniak', 7),
(154, 'Dorota', 'Krawiec', 7),
(155, 'Tomasz', 'Zawadzki', 7),
(156, 'Alicja', 'Piasecka', 7),
(157, 'Łukasz', 'Sawicki', 7),
(158, 'Elżbieta', 'Dąbrowska', 7),
(159, 'Joanna', 'Rybak', 7),
(160, 'Maciej', 'Borowski', 8),
(161, 'Anna', 'Kuczyńska', 8),
(162, 'Kamil', 'Nowak', 8),
(163, 'Magdalena', 'Górska', 8),
(164, 'Jakub', 'Orłowski', 8),
(165, 'Aleksander', 'Sadowski', 8),
(166, 'Oliwia', 'Baranowska', 8),
(167, 'Marek', 'Woźniak', 8),
(168, 'Piotr', 'Wróblewski', 8),
(169, 'Roksana', 'Jasińska', 8),
(170, 'Karol', 'Brzeziński', 8),
(171, 'Natalia', 'Zawadzka', 8),
(172, 'Łucja', 'Duda', 8),
(173, 'Tomasz', 'Kędzierski', 8),
(174, 'Daria', 'Czarnecki', 8),
(175, 'Barbara', 'Malinowska', 8),
(176, 'Patryk', 'Adamski', 8),
(177, 'Agnieszka', 'Wesołowska', 8),
(178, 'Ewa', 'Mazurek', 8),
(179, 'Wojciech', 'Marek', 8),
(180, 'Eliza', 'Gajewska', 9),
(181, 'Paweł', 'Błaszczyk', 9),
(182, 'Kornelia', 'Pawlak', 9),
(183, 'Michał', 'Grzegorczyk', 9),
(184, 'Emilia', 'Kozioł', 9),
(185, 'Zofia', 'Tomaszewska', 9),
(186, 'Kacper', 'Maciejewski', 9),
(187, 'Oskar', 'Rataj', 9),
(188, 'Anna', 'Lis', 9),
(189, 'Sebastian', 'Olejniczak', 9),
(190, 'Bartosz', 'Czajka', 9),
(191, 'Patrycja', 'Barańska', 9),
(192, 'Wiktoria', 'Szewczyk', 9),
(193, 'Artur', 'Kubicki', 9),
(194, 'Natalia', 'Cieślik', 9),
(195, 'Tadeusz', 'Wysocki', 9),
(196, 'Jan', 'Markowski', 9),
(197, 'Gabriela', 'Michalska', 9),
(198, 'Elżbieta', 'Łukasik', 9),
(199, 'Damian', 'Leśniak', 9),
(200, 'Małgorzata', 'Urban', 9),
(201, 'Stefan', 'Kowal', 9),
(202, 'Izabela', 'Sobolewska', 9),
(203, 'Wiesław', 'Jaworski', 10),
(204, 'Angelika', 'Zielińska', 10),
(205, 'Danuta', 'Bielecka', 10),
(206, 'Janusz', 'Wojciechowski', 10),
(207, 'Magdalena', 'Domańska', 10),
(208, 'Konrad', 'Kasprzyk', 10),
(209, 'Andrzej', 'Matuszewski', 10),
(210, 'Joanna', 'Pietrzak', 10),
(211, 'Tomasz', 'Woźniak', 10),
(212, 'Urszula', 'Kurowska', 10),
(213, 'Katarzyna', 'Nawrocka', 10),
(214, 'Aleksy', 'Laskowski', 10),
(215, 'Łukasz', 'Marciniak', 10),
(216, 'Jerzy', 'Wierzbicki', 10),
(217, 'Dorota', 'Przybylska', 10),
(218, 'Marek', 'Czerny', 10),
(219, 'Katarzyna', 'Zięba', 10),
(220, 'Monika', 'Dzięgiel', 10),
(221, 'Szymon', 'Krajewski', 10),
(222, 'Renata', 'Kozłowska', 10),
(223, 'Wioletta', 'Sowa', 10),
(224, 'Karolina', 'Nowakowska', 11),
(225, 'Jakub', 'Wójcik', 11),
(226, 'Dawid', 'Kaczmarek', 11),
(227, 'Klaudia', 'Majcher', 11),
(228, 'Patryk', 'Stolarz', 11),
(229, 'Barbara', 'Wiśniewska', 11),
(230, 'Mikołaj', 'Jankowski', 11),
(231, 'Monika', 'Pawlak', 11),
(232, 'Marta', 'Filipek', 11),
(233, 'Jakub', 'Sierżant', 11),
(234, 'Aleksandra', 'Moc', 11),
(235, 'Marek', 'Bielecki', 11),
(236, 'Patrycja', 'Rogal', 11),
(237, 'Katarzyna', 'Żuraw', 11),
(238, 'Sebastian', 'Król', 11),
(239, 'Aneta', 'Kwiatkowska', 11),
(240, 'Kamil', 'Zawisza', 11),
(241, 'Martyna', 'Żuraw', 11),
(242, 'Michał', 'Kocot', 11),
(243, 'Beata', 'Kosek', 11),
(244, 'Piotr', 'Kleczkowski', 11),
(245, 'Łukasz', 'Mazur', 12),
(246, 'Ewa', 'Olszewska', 12),
(247, 'Wojciech', 'Sokołowski', 12),
(248, 'Natalia', 'Chmielewska', 12),
(249, 'Michał', 'Szymański', 12),
(250, 'Paulina', 'Cholewa', 12),
(251, 'Krzysztof', 'Kowalski', 12),
(252, 'Aleksandra', 'Białek', 12),
(253, 'Daria', 'Kaczmarek', 12),
(254, 'Damian', 'Czerwiński', 12),
(255, 'Iwona', 'Sienkiewicz', 12),
(256, 'Sylwia', 'Piwowar', 12),
(257, 'Wojciech', 'Maj', 12),
(258, 'Maciej', 'Piotrkowski', 12),
(259, 'Patrycja', 'Pękala', 12),
(260, 'Magdalena', 'Zawisza', 12),
(261, 'Tomasz', 'Głogowski', 12),
(262, 'Mariusz', 'Wójcik', 12),
(263, 'Piotr', 'Sowa', 12),
(264, 'Artur', 'Białek', 12),
(265, 'Katarzyna', 'Lipska', 12),
(266, 'Joanna', 'Król', 12),
(267, 'Oskar', 'Domański', 13),
(268, 'Bartosz', 'Czajka', 13),
(269, 'Marek', 'Polak', 13),
(270, 'Agata', 'Nowakowska', 13),
(271, 'Michał', 'Cieślak', 13),
(272, 'Zuzanna', 'Kowalska', 13),
(273, 'Marta', 'Stolarz', 13),
(274, 'Paulina', 'Krysiak', 13),
(275, 'Damian', 'Tomaszewski', 13),
(276, 'Klaudia', 'Sienkiewicz', 13),
(277, 'Jakub', 'Róg', 13),
(278, 'Monika', 'Chmielewska', 13),
(279, 'Damian', 'Zieliński', 13),
(280, 'Katarzyna', 'Żuraw', 13),
(281, 'Mikołaj', 'Matuszewski', 13),
(282, 'Maciej', 'Żuraw', 13),
(283, 'Anna', 'Pięciak', 13),
(284, 'Wiktoria', 'Sikora', 13),
(285, 'Karol', 'Borkowski', 13),
(286, 'Natalia', 'Górska', 14),
(287, 'Jacek', 'Jankowski', 14),
(288, 'Sebastian', 'Piasecki', 14),
(289, 'Katarzyna', 'Wierzbicka', 14),
(290, 'Patryk', 'Mazur', 14),
(291, 'Michał', 'Maciak', 14),
(292, 'Beata', 'Szymańska', 14),
(293, 'Damian', 'Mazur', 14),
(294, 'Julia', 'Tomaszewska', 14),
(295, 'Wiktoria', 'Bielawska', 14),
(296, 'Kamil', 'Gajda', 14),
(297, 'Magdalena', 'Bodziony', 14),
(298, 'Joanna', 'Laska', 14),
(299, 'Andrzej', 'Zawisza', 14),
(300, 'Martyna', 'Głogowska', 14),
(301, 'Daria', 'Zielińska', 14),
(302, 'Karolina', 'Czajka', 14),
(303, 'Eliza', 'Kwiatkowska', 14),
(304, 'Marek', 'Nowakowski', 14),
(305, 'Piotr', 'Zawisza', 14),
(306, 'Agnieszka', 'Kowalska', 15),
(307, 'Marek', 'Kwiatkowski', 15),
(308, 'Damian', 'Ostrowski', 15),
(309, 'Emilia', 'Laskowska', 15),
(310, 'Krzysztof', 'Kwiatkowski', 15),
(311, 'Szymon', 'Wilk', 15),
(312, 'Jakub', 'Filipek', 15),
(313, 'Piotr', 'Szymański', 15),
(314, 'Michał', 'Czarnecki', 15),
(315, 'Anna', 'Bielawska', 15),
(316, 'Filip', 'Wolski', 15),
(317, 'Sebastian', 'Kubicki', 15),
(318, 'Magdalena', 'Nowakowska', 15),
(319, 'Artur', 'Leśniak', 15),
(320, 'Łukasz', 'Sienkiewicz', 15),
(321, 'Kacper', 'Kowalski', 15),
(322, 'Patrycja', 'Górska', 15),
(323, 'Monika', 'Czajka', 15),
(324, 'Bartosz', 'Stolarz', 15),
(325, 'Tomasz', 'Nowak', 15),
(326, 'Katarzyna', 'Bodziony', 15),
(327, 'Dawid', 'Mazur', 15),
(328, 'Łukasz', 'Marek', 16),
(329, 'Michał', 'Wilk', 16),
(330, 'Natalia', 'Wójcik', 16),
(331, 'Andrzej', 'Sadowski', 16),
(332, 'Patryk', 'Mroz', 16),
(333, 'Katarzyna', 'Feldman', 16),
(334, 'Damian', 'Stolarz', 16),
(335, 'Zofia', 'Siwek', 16),
(336, 'Maciej', 'Grzelak', 16),
(337, 'Agnieszka', 'Kaczmarek', 16),
(338, 'Karol', 'Piasecki', 16),
(339, 'Jakub', 'Cieślak', 16),
(340, 'Joanna', 'Zawisza', 16),
(341, 'Wiktoria', 'Białek', 16),
(342, 'Katarzyna', 'Markowska', 16),
(343, 'Michał', 'Biernat', 16),
(344, 'Alicja', 'Róg', 16),
(345, 'Sebastian', 'Zawisza', 16),
(346, 'Kinga', 'Król', 16),
(347, 'Marek', 'Zieliński', 16),
(348, 'Mariusz', 'Sowa', 16),
(349, 'Michał', 'Kołodziej', 16),
(350, 'Monika', 'Rogal', 16),
(351, 'Maciej', 'Tomaszewski', 17),
(352, 'Anna', 'Wojciechowska', 17),
(353, 'Kamil', 'Tomaszewski', 17),
(354, 'Joanna', 'Kubicka', 17),
(355, 'Filip', 'Piotrowski', 17),
(356, 'Elżbieta', 'Chmiel', 17),
(357, 'Adrian', 'Nowak', 17),
(358, 'Dorota', 'Marciniak', 17),
(359, 'Jakub', 'Rybak', 17),
(360, 'Paweł', 'Szczepaniak', 17),
(361, 'Mariusz', 'Jasiński', 17),
(362, 'Natalia', 'Pietrzak', 17),
(363, 'Wojciech', 'Mazur', 17),
(364, 'Magdalena', 'Woźniak', 17),
(365, 'Patryk', 'Król', 17),
(366, 'Sebastian', 'Urban', 17),
(367, 'Michał', 'Urbański', 17),
(368, 'Karolina', 'Kosmatka', 17),
(369, 'Andrzej', 'Kaczmarek', 17),
(370, 'Patrycja', 'Tomaszewska', 17),
(371, 'Jakub', 'Mazurek', 17),
(372, 'Zuzanna', 'Borkowska', 17),
(373, 'Krzysztof', 'Żuraw', 17),
(374, 'Sylwia', 'Grzelak', 17),
(375, 'Tomasz', 'Górka', 18),
(376, 'Martyna', 'Mazur', 18),
(377, 'Piotr', 'Włodarczyk', 18),
(378, 'Katarzyna', 'Sikora', 18),
(379, 'Krzysztof', 'Borkowski', 18),
(380, 'Wojciech', 'Gajda', 18),
(381, 'Elżbieta', 'Kwiatkowska', 18),
(382, 'Jakub', 'Woźniak', 18),
(383, 'Marcin', 'Mazurek', 18),
(384, 'Marek', 'Chmielewski', 18),
(385, 'Anna', 'Jasińska', 18),
(386, 'Krzysztof', 'Zawisza', 18),
(387, 'Wojciech', 'Rogal', 18),
(388, 'Jacek', 'Pawlak', 18),
(389, 'Magdalena', 'Kasprzyk', 18),
(390, 'Agnieszka', 'Laskowska', 18),
(391, 'Sebastian', 'Jankowski', 18),
(392, 'Kinga', 'Matuszewska', 18),
(393, 'Michał', 'Markowski', 18),
(394, 'Patryk', 'Marciniak', 18),
(395, 'Andrzej', 'Duda', 18),
(396, 'Ewa', 'Filipek', 18),
(397, 'Maciej', 'Kwiatkowski', 18),
(398, 'Joanna', 'Kowalska', 18),
(399, 'Filip', 'Baranowski', 19),
(400, 'Adrian', 'Pawlak', 19),
(401, 'Marek', 'Marciniak', 19),
(402, 'Krzysztof', 'Rybak', 19),
(403, 'Monika', 'Kowalska', 19),
(404, 'Tomasz', 'Gajda', 19),
(405, 'Damian', 'Chmiel', 19),
(406, 'Katarzyna', 'Tomaszewska', 19),
(407, 'Michał', 'Cieślik', 19),
(408, 'Wiktoria', 'Zawisza', 19),
(409, 'Piotr', 'Szymański', 19),
(410, 'Kinga', 'Zawisza', 19),
(411, 'Anna', 'Zielińska', 19),
(412, 'Bartosz', 'Kasprzyk', 19),
(413, 'Karolina', 'Król', 19),
(414, 'Michał', 'Tomaszewski', 19),
(415, 'Damian', 'Woźniak', 19),
(416, 'Karol', 'Pawlak', 19),
(417, 'Łukasz', 'Kwiatkowski', 19),
(418, 'Patryk', 'Szymański', 19),
(419, 'Alicja', 'Szczepaniak', 19),
(420, 'Marcin', 'Kubicki', 19),
(421, 'Marek', 'Tomaszewski', 19),
(422, 'Sebastian', 'Pawlak', 20),
(423, 'Maciej', 'Bielawski', 20),
(424, 'Wojciech', 'Kosmatka', 20),
(425, 'Beata', 'Kwiatkowska', 20),
(426, 'Damian', 'Szydłowski', 20),
(427, 'Łukasz', 'Piasecki', 20),
(428, 'Wiktoria', 'Król', 20),
(429, 'Katarzyna', 'Żuraw', 20),
(430, 'Kamil', 'Tomaszewski', 20),
(431, 'Wojciech', 'Kowalski', 20),
(432, 'Monika', 'Jankowska', 20),
(433, 'Marta', 'Kwiatkowska', 20),
(434, 'Piotr', 'Wójcik', 20),
(435, 'Natalia', 'Borkowska', 20),
(436, 'Marek', 'Mazur', 20),
(437, 'Tomasz', 'Jankowski', 20),
(438, 'Anna', 'Szymczak', 20),
(439, 'Patryk', 'Róg', 20),
(440, 'Michał', 'Ławniczak', 20),
(441, 'Piotr', 'Woźniak', 20),
(442, 'Monika', 'Rogal', 20),
(443, 'Daria', 'Filipek', 20),
(444, 'Marek', 'Kołodziej', 20),
(445, 'Zofia', 'Kwiatkowska', 20);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `user_name`, `password`) VALUES
(1, 'admin', 'admin');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `klasy`
--
ALTER TABLE `klasy`
  ADD PRIMARY KEY (`Klasa_id`);

--
-- Indeksy dla tabeli `nauczyciele`
--
ALTER TABLE `nauczyciele`
  ADD PRIMARY KEY (`Nauczyciel_id`);

--
-- Indeksy dla tabeli `plan_lekcji`
--
ALTER TABLE `plan_lekcji`
  ADD PRIMARY KEY (`Lekcja_id`),
  ADD KEY `Klasa_id` (`Klasa_id`),
  ADD KEY `Sala_id` (`Sala_id`),
  ADD KEY `Nauczyciel_id` (`Nauczyciel_id`);

--
-- Indeksy dla tabeli `sale`
--
ALTER TABLE `sale`
  ADD PRIMARY KEY (`Sala_id`);

--
-- Indeksy dla tabeli `szczensliwy_numer`
--
ALTER TABLE `szczensliwy_numer`
  ADD PRIMARY KEY (`date`);

--
-- Indeksy dla tabeli `uczen`
--
ALTER TABLE `uczen`
  ADD PRIMARY KEY (`Uczen_id`),
  ADD KEY `Klasa_id` (`Klasa_id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `klasy`
--
ALTER TABLE `klasy`
  MODIFY `Klasa_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `nauczyciele`
--
ALTER TABLE `nauczyciele`
  MODIFY `Nauczyciel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `plan_lekcji`
--
ALTER TABLE `plan_lekcji`
  MODIFY `Lekcja_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sale`
--
ALTER TABLE `sale`
  MODIFY `Sala_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `uczen`
--
ALTER TABLE `uczen`
  MODIFY `Uczen_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=446;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `plan_lekcji`
--
ALTER TABLE `plan_lekcji`
  ADD CONSTRAINT `plan_lekcji_ibfk_1` FOREIGN KEY (`Klasa_id`) REFERENCES `klasy` (`Klasa_id`),
  ADD CONSTRAINT `plan_lekcji_ibfk_2` FOREIGN KEY (`Sala_id`) REFERENCES `sale` (`Sala_id`),
  ADD CONSTRAINT `plan_lekcji_ibfk_3` FOREIGN KEY (`Nauczyciel_id`) REFERENCES `nauczyciele` (`Nauczyciel_id`);

--
-- Constraints for table `uczen`
--
ALTER TABLE `uczen`
  ADD CONSTRAINT `uczen_ibfk_1` FOREIGN KEY (`Klasa_id`) REFERENCES `klasy` (`Klasa_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
