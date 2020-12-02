-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 02, 2020 at 07:17 AM
-- Server version: 10.3.24-MariaDB-log-cll-lve
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `kortjwxc_elects_new`
--

-- --------------------------------------------------------

--
-- Dumping data for table `office_branches`
--

INSERT INTO `office_branches` (`id`, `city`, `country`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Lagos', 'Nigeria', NULL, NULL, NULL);


-- --------------------------------------------------------

--
-- Dumping data for table `accountants`
--

INSERT INTO `accountants` (`id`, `full_name`, `email`, `password`, `gender`, `office_branch_id`, `is_active`, `verified_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'SysDef Sales Rep', 'salesrep@theelects.com', '$2y$10$Z5avsxgSUPsKA3BhNbonsuERFBggC.8gDLb/pPIdDu8SRMoffEmx.', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:03', '2020-10-27 15:56:03', NULL),
(2, 'Debby', 'debby.am@theelects.com', '$2y$10$c6X2ksr7ApApNUdMatm6jO.AXyUMJ9qVzhP5Ahd4uBg2eS76zw/XK', NULL, 1, NULL, '2020-10-27 17:41:39', 'vo4aWwyDUugh80i4UALQ4BlYBWIjBvAVa7pWadK4nFmLuqzIRSaig6wrHl9s', '2020-10-27 15:56:03', '2020-10-27 17:41:39', NULL),
(3, 'Ursula Lakin', 'gleason.dax@hotmail.com', '$2y$10$g8ZhNnzHk8lSFaa10q9KTO95oDX5oQAD1Y7P9LouO5ajXco0hi1em', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:03', '2020-10-27 15:56:03', NULL),
(4, 'Mafalda Toy', 'jgreenfelder@yahoo.com', '$2y$10$6uH5bMxXh9BVB89EXtzChO1D0B4wO1MtQnFywt7dj.lsniOTvL93G', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:03', '2020-10-27 15:56:03', NULL),
(5, 'Jaqueline Kertzmann Sr.', 'grady.jayme@mayert.biz', '$2y$10$hm7uCQcdXiH6gbyYCSgB.OSlTHahR3OECaD/a1QnlV5Mrwy9GLu3O', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:03', '2020-10-27 15:56:03', NULL),
(6, 'Cortez Zulauf II', 'larue.ernser@gmail.com', '$2y$10$Lia3pXIWASKE8R6YTMmWwuyRW4s5P3QUfhHVwO4skT04nM01U0LGS', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:03', '2020-10-27 15:56:03', NULL);

-- --------------------------------------------------------

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `full_name`, `email`, `password`, `gender`, `office_branch_id`, `is_active`, `verified_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'SysDef Admin', 'admin@theelects.com', '$2y$10$PC8tQXcJDxyJbLuTsRwfMuyLKkyj3jxxmKfxV3SCiTsqSz2t1LT/S', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:02', '2020-10-27 15:56:02', NULL),
(2, 'Daniel', 'daniel.edirin@theelects.com', '$2y$10$3nTezi7IVbeEVBUsn2xhnuDXKqGt2AWXKNiLmdljLRJMQIkUtn7um', NULL, 1, NULL, '2020-10-30 12:51:28', 'dwxwsiTpErU8euwWtHC8HSYKLRlFv08H7CWF6nbhkCGwYNPSYwSaYlKeplOn', '2020-10-27 15:56:03', '2020-10-30 12:51:28', NULL),
(3, 'Rozella Krajcik', 'adelia.schmeler@sauer.com', '$2y$10$2md0hiUAv9P90c6r3wCWLuatGNNIq9fw4uV2NRGYGIeleAA9NpVzW', NULL, 1, NULL, '2020-10-27 18:17:27', 'OzLi7QwK3FxRQNq3PT9SE1e3mE17e4lFaZfAJhsZwxffxkHTiINXj1FUvtok', '2020-10-27 15:56:03', '2020-10-27 18:17:27', NULL),
(4, 'Gussie Klocko', 'theodore41@west.com', '$2y$10$6QeUbSqnjicBUnHUshsAJOjB69jiu0cO4fZBS240efNHhWgq3w9Qq', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:03', '2020-10-27 15:56:03', NULL),
(5, 'Mose Boyle', 'mueller.abigale@hill.info', '$2y$10$xdx01W23yxsMbejHu.qlqeeDCpxxfw6kNRn62xBKfIq71PuaYbcju', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:03', '2020-10-27 15:56:03', NULL),
(6, 'Breana O\'Kon', 'ottis83@treutel.org', '$2y$10$P.xas3nZ0ED0uAI64wI1FekuOXIzs4DvwYid1KjsUORsBdPyjkALq', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:03', '2020-10-27 15:56:03', NULL);

-- --------------------------------------------------------

--
-- Dumping data for table `dispatch_admins`
--

INSERT INTO `dispatch_admins` (`id`, `full_name`, `email`, `password`, `gender`, `office_branch_id`, `is_active`, `verified_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'SysDef Dispatch Admin', 'dispatchadmin@theelects.com', '$2y$10$poaSkhoZxJt0sjkN4YZrlOQdDUmyv9fk2VaDhuaKEllzYWJFBJsdy', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:06', '2020-10-27 15:56:06', NULL),
(2, 'Ronke', 'ronke.d@theelects.com', '$2y$10$i9fKRR0lt/TwRpw3RxF4q.kdExOq5xzowlDSQ5QKGgTpjXEgs5rDi', NULL, 1, NULL, '2020-10-27 18:12:44', '0dy02NE4GnkmkSOLFx16TERCnUoSH5F5N5EhZXoLnohKhmtPuYrnjWpPBu1V', '2020-10-27 15:56:06', '2020-10-27 18:12:44', NULL),
(3, 'Alycia Hackett', 'joyce.bergstrom@yahoo.com', '$2y$10$MnijIiUhp7uZdkQN80q1EeFUt9SC7jHoC3GAAhUtOdDWf.JC/rady', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:06', '2020-10-27 15:56:06', NULL),
(4, 'Dr. Hunter Jacobson Sr.', 'amaya.fahey@maggio.com', '$2y$10$XBtiwQK0VJwv/kF17RAtre3nqheb.khyZdQxGGvUaCYzcLu3oF6rq', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:06', '2020-10-27 15:56:06', NULL),
(5, 'Aron Pouros', 'okirlin@bailey.org', '$2y$10$i5R9X9jHdGCmGaxH/aR56.8lAe910mZdiZX7kBwlR10URw2N02gtS', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:06', '2020-10-27 15:56:06', NULL),
(6, 'Alexander Kuphal III', 'reggie42@yahoo.com', '$2y$10$nvJSPpAftFYvJDQ2kAWcLOhmdV3vVDNcz0raZ5m3nCFdDi5MG6yQm', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:06', '2020-10-27 15:56:06', NULL);

-- --------------------------------------------------------

--
-- Dumping data for table `quality_controls`
--

INSERT INTO `quality_controls` (`id`, `full_name`, `email`, `password`, `gender`, `office_branch_id`, `is_active`, `verified_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'SysDef Quality Control', 'qualitycontrol@theelects.com', '$2y$10$agHMBZHP6mVP5H4xUn96oesYTJEIY7aS6D0WFUoM2dxV9O5dsDEp.', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:07', '2020-10-27 15:56:07', NULL),
(2, 'Wale Jimoh', 'jimoh.le@theelects.com', '$2y$10$Loy/ZuvC/DBHZjrsmxOrP.Q18Md9gDh9qQqNVnlSJ1DfefcfRxaxG', 'male', 1, NULL, '2020-10-27 17:31:48', 'DpcG1WUfjCfljAzck1WglRoNRHLNkLHIxBQAX0MOE8iXNLLcfAVaBaM8ByAQ', '2020-10-27 15:56:07', '2020-10-27 17:31:48', NULL),
(3, 'Elizabeth Adeoti', 'lizzy.oit@theelects.com', '$2y$10$wnnOkPStEFJ3yHgQ6JkyROqwkNhr6RH4Cy3nagLkl.kmn2By9YFkC', 'female', 1, NULL, '2020-10-27 17:32:22', 'LiP5u4JtMuSRHyW6yTqWEH3pLvkAITWzVlaa58m2itT8dbrMwwWrqsaQJJbW', '2020-10-27 15:56:07', '2020-10-27 17:32:22', NULL),
(4, 'Godwin Osang', 'godwin.ng@theelects.com', '$2y$10$Bby/USqXtr59EaRKXzg5i.vr4Fmbl2zq0a83a6AqYE2jIOsqZuBVa', 'male', 1, NULL, '2020-10-27 18:23:10', 'CX3RB2rbAHpm2aZRRxIVzzGrzdzoR6uxl7cznvTOwsABN3qcKaU2fneAuFeE', '2020-10-27 15:56:07', '2020-10-27 18:23:10', NULL),
(5, 'Marilou Gerhold I', 'dicki.zackery@hotmail.com', '$2y$10$dk02xeBhJIOGhSEfnfK0cesqr/W4KRlu5N.paa1bLctpb/qojAmd.', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:07', '2020-10-27 15:56:07', NULL),
(6, 'Mr. Ignacio Jacobs MD', 'dedric98@yahoo.com', '$2y$10$LtV07ZkDG.e.3aSveiEF3uXRym6vPYQrVI8X30u2JJtdoLuuvMD9y', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:07', '2020-10-27 15:56:07', NULL),
(7, 'Lillie Huels', 'uheathcote@cole.com', '$2y$10$4h2UKfpTsOjB0nj7XWspHeqbln1HTx.rHp3v0QUQY5kGJotkgLIZC', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:07', '2020-10-27 15:56:07', NULL),
(8, 'Katelyn Labadie', 'kris.neil@frami.com', '$2y$10$90.2NuZdDFS.UKk368QH0OaGa81gFyw/4GtLE..pOO2uSP30zHXku', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:07', '2020-10-27 15:56:07', NULL),
(9, 'Allen Bartell', 'lorena.treutel@ondricka.biz', '$2y$10$RY2E.gcE.VlM3ajY/rf8Z.e8n7UFpSzN/9jL43f5So0JU5KqOFUmG', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:07', '2020-10-27 15:56:07', NULL),
(10, 'Prof. Fanny Hickle V', 'idurgan@zieme.com', '$2y$10$wjMJWqDpCPEq1fNADPZr8.UszwGe3Kv64VQCUFkQFXLKUslR0VmsO', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:07', '2020-10-27 15:56:07', NULL),
(11, 'Dr. Dane Pouros III', 'chad.gaylord@lemke.com', '$2y$10$5fcgh7aAbk3rvu4BoDAn2O2grim.Ix1d1HWPwUAPzNXHa9co0IVLC', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:07', '2020-10-27 15:56:07', NULL);

-- --------------------------------------------------------

--
-- Dumping data for table `sales_reps`
--

INSERT INTO `sales_reps` (`id`, `full_name`, `email`, `password`, `phone`, `avatar`, `address`, `unit`, `gender`, `office_branch_id`, `is_active`, `verified_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'SysDef Sales Rep', 'salesrep@theelects.com', '$2y$10$R/NbGDMFfT9kUL9Gn4g/EOgNWVvQE5rBMUldoVxtiLsfeMdiCkrOa', NULL, NULL, NULL, 'sys-default', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:03', '2020-10-27 15:56:03', NULL),
(2, 'Joy Simon', 'joy@theelects.com', '$2y$10$D5T9DaMm6ajy0miNBmMQw.fVYKZQRTqwO5zopJONmQ//PvlSYEaxm', NULL, NULL, NULL, 'walk-in', 'female', 1, NULL, '2020-10-27 17:16:09', '7B6wkMxxRELRW25VBMrZvBlJlZ3MT5VW9J24xuwGXHLUtF7b2mHwnWnUhYn2', '2020-10-27 15:56:04', '2020-10-27 17:16:09', NULL),
(3, 'Bisi Banjo', 'bisi.bj@theelects.com', '$2y$10$V7zs7zTcyNzyw.4H4eVbqe5bJ4LGMVNC62YGblf0hdk2J/oss60rK', NULL, NULL, NULL, 'walk-in', 'female', 1, NULL, '2020-10-29 16:22:35', 'miAZrn5UGa0McA91UNq4QYsbasmhJetM60baBQkNTyJNOHZjGpLJHiqLsKuH', '2020-10-27 15:56:04', '2020-10-29 16:22:35', NULL),
(4, 'Eddy', 'eddy.rd@theelects.com', '$2y$10$oD9Xs0WWNm1hMjIUGLZO2OrH1lUgHBQNQRFRvmRI15jOqHEH6TtR.', NULL, NULL, NULL, 'walk-in', 'male', 1, NULL, '2020-10-29 17:07:56', 'RK8S7m9OVF4rNFx3ZerCJH9LGqigq29212U2aOsVY6RXUlycYvrEyEGFnOgS', '2020-10-27 15:56:04', '2020-10-29 17:07:56', NULL),
(5, 'Jesse', 'jesse.ed@theelects.com', '$2y$10$MU8eWk.5.GFSyY2SV.6fHOtvv0CPDqLPp7xy8DcFQ4Be3nDsPg1iO', NULL, NULL, NULL, 'walk-in', 'male', 1, NULL, '2020-10-27 18:12:05', 'It631DUduTPDwkb13MKNfsVFuf5odyKYClQBRXnljHFiTD5lfjBBkJkJthtx', '2020-10-27 15:56:04', '2020-10-27 18:12:05', NULL),
(6, 'Kemi Olayinka', 'kemi.ola@theelects.com', '$2y$10$5DVwU5tv5VZK.QtCz9y/BeBrh0vWfj2QBb2lPndd1KuBWLe5PgMTG', NULL, NULL, NULL, 'social-media', 'female', 1, NULL, '2020-10-27 17:26:55', 'imrJCjbchrLqdsHnt8ZQhrNp8afOziup8AHtSPQQjihaKx3fgV3fFBKaCFbR', '2020-10-27 15:56:04', '2020-10-27 17:26:55', NULL),
(7, 'Mayhelen Anah', 'may.hel@theelects.com', '$2y$10$6i1bZUYdoe0lV3NwC1K4QOS/eD084r3wsC/K0TrieBypIUEcn.mBO', NULL, NULL, NULL, 'social-media', 'female', 1, NULL, '2020-10-27 18:14:08', '8BnIsTjEYUrBuHwKysOGLjO43JlwqMq4X8nDJM53YWOIjDBySgYE6TEqcMS8', '2020-10-27 15:56:04', '2020-10-27 18:14:08', NULL),
(8, 'Debo', 'debo.dd@theelects.com', '$2y$10$LHpwHv1rN25/w3LJRs0gGuS738fVb3T3usJct8mz8akk5A53Xtxvu', NULL, NULL, NULL, 'social-media', 'male', 1, NULL, '2020-10-27 17:30:19', 'CGWepvmlwvVadB80myAwTb0OAOgXJ3dEYMN7RxMdssCv3gQOCaOFaguMQ3kr', '2020-10-27 15:56:04', '2020-10-27 17:30:19', NULL),
(9, 'Simi Awos', 'simi.aw@theelects.com', '$2y$10$2UgJd3bd7Ye6GH5/KxXJM.DwhQjOtb1t78PYIJc3STSOxUDO8xfy.', NULL, NULL, NULL, 'social-media', 'female', 1, NULL, '2020-10-27 17:29:43', 'DKK1xh2KO8iKX42LghmuaZLh0w9VGNVuylmWVnyaoPb6x3xnhz14oFH2SyqA', '2020-10-27 15:56:05', '2020-10-27 17:29:43', NULL),
(10, 'Blessing', 'blessing.ch@theelects.com', '$2y$10$gffq0r2phbtv9LpBFjyLJO3uc37KlBPHB7QhmVOKURsfPqNub32iW', NULL, NULL, NULL, 'call-center', 'female', 1, NULL, '2020-10-27 17:26:07', 'J11TGlU6gZ441ATMspdvxdWPqxk9AI8uW03UcdpaGP78GW1TsfU9DTHuJoz2', '2020-10-27 15:56:05', '2020-10-27 17:26:07', NULL),
(11, 'Yuyu Angela', 'angela.yuyu@theelects.com', '$2y$10$STuv.2GlPxAmCklcUX3ZT.gFZpJtQNLJW4/MQMYiIpcEh0LgKv/LK', NULL, NULL, NULL, 'call-center', 'female', 1, NULL, '2020-10-27 17:32:30', 'UmWQDNTR9AygryxYMqSFbhT0ooV6R1LxzCs4MjEj9XhrWdrUA96JIQBh1Lix', '2020-10-27 15:56:05', '2020-10-27 17:32:30', NULL),
(12, 'Jane Nwachukwu', 'jane.chukwu@theelects.com', '$2y$10$5C6RB2Rb03gPmArMOGFZJu38D7Zdk.udEhg.brTForuxRzrvd0VG2', NULL, NULL, NULL, 'social-media', 'female', 1, NULL, '2020-10-27 17:25:28', 'HXI42umTkXGzMpHOhpjCblRW9z1q4TNNVg4KJff7SEs1QZpnXV3Bt4GXg5yT', '2020-10-27 15:56:05', '2020-10-27 17:25:28', NULL),
(13, 'Tillman Ziemann', 'mikayla54@hintz.biz', '$2y$10$faydsFAjxS3I6jrgcoD9LuiB6vxF0yjmRL4dixSFBiZAIQKNlKHES', NULL, NULL, NULL, 'social-media', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:05', '2020-10-27 15:56:05', NULL),
(14, 'Gus Altenwerth', 'breanne39@gorczany.com', '$2y$10$khL58xOkB/7iK2HJ8Mc30u2/2ok/eYJstTBjVtXZQ..F7.C2nyy9C', NULL, NULL, NULL, 'social-media', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:05', '2020-10-27 15:56:05', NULL),
(15, 'Dr. Elmer Emard', 'torphy.vivianne@armstrong.com', '$2y$10$s6BCZSag/DSyy4VqH2yhDeFIldV6cjNxqsn7nR.BUh.gx8wquK/GS', NULL, NULL, NULL, 'walk-in', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:05', '2020-10-27 15:56:05', NULL),
(16, 'Dr. Sharon Becker IV', 'altenwerth.brandi@schmidt.com', '$2y$10$Cb6cjWpkU8TDh4JfnpHfX.9VVCiU1ZWjjx/lBbKSmOieIpZwRDJKC', NULL, NULL, NULL, 'call-center', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:05', '2020-10-27 15:56:05', NULL);

-- --------------------------------------------------------

--
-- Dumping data for table `stock_keepers`
--

INSERT INTO `stock_keepers` (`id`, `full_name`, `email`, `password`, `gender`, `office_branch_id`, `is_active`, `verified_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Mr. Zackary Luettgen', 'rgislason@kemmer.com', '$2y$10$XtT23.RUBasUcK/JCZ.e7OZ8lSB99Ve7EUy9phR3DX5XdbtpwkMwq', NULL, 1, NULL, NULL, NULL, '2020-10-27 16:37:00', '2020-10-27 16:37:00', NULL),
(3, 'Bimpe Adebayo', 'bimpe.de@theelects.com', '$2y$10$8UuXVusZDy/nCo9NBbyvyuEdobHsd8mBzqc3j/zLwhpVTTH4wVDRW', NULL, 1, NULL, '2020-10-27 17:09:58', 'OVF42C9nLcPrjytwLSolniKb7umnn9eZtMkDApoXi36VfP5iOPcK01w6vn7S', '2020-10-27 16:37:00', '2020-10-27 17:09:58', NULL),
(4, 'Elmira Connelly', 'salvatore75@gmail.com', '$2y$10$qGLr4r1Y6UlK01hi8x2ACeAJOTzjFr9GDpA8rCfeIx1GGPI4qseAS', NULL, 1, NULL, NULL, NULL, '2020-10-27 16:37:00', '2020-10-27 16:37:00', NULL),
(5, 'Sherwood Bode', 'lincoln99@yahoo.com', '$2y$10$Yrpp7ZPCqtOoWCzpxvc62.aYd/VVVzw15XuySZaGpao4IAoHw34e.', NULL, 1, NULL, NULL, NULL, '2020-10-27 16:37:00', '2020-10-27 16:37:00', NULL),
(6, 'Ms. Zaria Koelpin II', 'alexys.barton@hotmail.com', '$2y$10$DglwKV.KCnsC65GNnnpCceYP.xp/VHvClH/a1x.RRUa.Vi8Qc.foi', NULL, 1, NULL, NULL, NULL, '2020-10-27 16:37:00', '2020-10-27 16:37:00', NULL),
(7, 'SysDef Sales Rep', 'stockkeeper@theelects.com', '$2y$10$VpoDnmN/V1BoS8YbJltjoeKBp.WmbqgP/p0VUrewIGofUkQUsQL/O', NULL, 1, NULL, NULL, NULL, '2020-10-27 16:57:07', '2020-10-27 16:57:07', NULL);

-- --------------------------------------------------------

--
-- Dumping data for table `trusted_romzy`
--

INSERT INTO `trusted_romzy` (`id`, `full_name`, `email`, `password`, `phone`, `avatar`, `gender`, `address`, `office_branch_id`, `verified_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'SysDef SuperAdmin', 'trustedromzy@theelects.com', '$2y$10$a.dM4towElbqx7.zx2slsuwFqHk0vQRS8qAqTDEjHQ4ypwldhByee', NULL, NULL, NULL, NULL, 1, NULL, NULL, '2020-10-27 15:56:08', '2020-10-27 15:56:08', NULL),
(2, 'Romzy', 'the-boss@theelects.com', '$2y$10$UeXF4qo6ZNEFzUcObI8Ya.kaluHzH7Ao16lR8K/1qNBYICgUANy6G', NULL, NULL, NULL, NULL, 1, NULL, '5tMj7PH1Uenwqja3wzWWtuu2pJGIW9l8kqjVJ7t6reuyiDDqr8GpVzsWzxvG', '2020-10-27 15:56:08', '2020-10-27 15:56:08', NULL),
(3, 'Oren Ernser', 'kub.clinton@wiegand.com', '$2y$10$gafBEsYiuJskb0npD32YRO1.REvl4DvsTVcs9umUNqW.OQViPSjsS', NULL, NULL, NULL, NULL, 1, NULL, 'u5s0Xh4nGE', '2020-10-27 15:56:08', '2020-10-27 15:56:08', NULL),
(4, 'Eldred Moen', 'marielle11@carroll.com', '$2y$10$8bi9Hz0Phep1X3VehUvnte3og4TBxxIxtmZNOwdlVbKQFgtMmE/yi', NULL, NULL, NULL, NULL, 1, NULL, '2t7AJSKgJX', '2020-10-27 15:56:08', '2020-10-27 15:56:08', NULL);

-- --------------------------------------------------------

--
-- Dumping data for table `web_admins`
--

INSERT INTO `web_admins` (`id`, `full_name`, `email`, `password`, `gender`, `office_branch_id`, `is_active`, `verified_at`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'SysDef Web Admin', 'webadmins@theelects.com', '$2y$10$o8a2ClPJgLpiuRkmcXyDTOlQzz5X7Bw1yPsVBWEDF0ZkFzGtvojR6', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:05', '2020-10-27 15:56:05', NULL),
(2, 'Ronke', 'ronke.we@theelects.com', '$2y$10$veWMIMdem48aSQesbm/s0ePVldgt4m9tWKdNNo1E03kSsUzG5c.Ve', 'female', 1, NULL, NULL, 'pwcdozJQLYWjDjunTWklKmNoHmaIpvbYl3M8hz3RKAdA1C2BcoKzLqQep2o3', '2020-10-27 15:56:05', '2020-10-27 15:56:05', NULL),
(3, 'Ms. Amaya Stoltenberg V', 'fabiola85@yahoo.com', '$2y$10$k2/L6oA9zPQfpgQ2KL5mRuzNWyGsgw0uTOA8konTI1fAkmAa1E5ne', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:05', '2020-10-27 15:56:05', NULL),
(4, 'Fae Buckridge', 'felton.mraz@gmail.com', '$2y$10$rIA0A.3cfG5d3pzHpzfGv.yfqK3.oQVmF8WvRvy8gzAOg/ced2NpW', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:05', '2020-10-27 15:56:05', NULL),
(5, 'Gennaro Kuphal', 'herman.elyssa@yahoo.com', '$2y$10$SfJjvLZMR8Z0qtCOhwfS4O2jwL/oWcqSQHjxeTfP12Haropzla2mK', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:05', '2020-10-27 15:56:05', NULL),
(6, 'Dr. Savion Durgan', 'lucienne.bartoletti@reichel.com', '$2y$10$/LkXyQm/ggVN7Hd51I227.MNn0DA6GJnS0rvYtjv59UJX0pBqsvyu', NULL, 1, NULL, NULL, NULL, '2020-10-27 15:56:05', '2020-10-27 15:56:05', NULL);

COMMIT;
