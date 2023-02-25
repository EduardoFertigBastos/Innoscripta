import React, { useCallback, useEffect, useState } from "react";

import SendIcon from "@mui/icons-material/Send";
import { Pagination } from "@mui/material";
import { Form as FormUnform } from "@unform/web";
import { MdOutlineDashboardCustomize } from "react-icons/md";

import Article from "components/Article";
import FormBuilder from "components/Form/FormBuilder";
import IGridField from "components/Form/FormBuilder/interfaces/IGridField";

import { useForm } from "hooks/form/useForm";
import { useSettings } from "hooks/settings";
import Toast from "hooks/toast/Toast";

import IArticle from "interfaces/entities/IArticle";

import api from "services/api";

import serializeParams from "utils/serializeParams";

import { MainDefault } from "styles/styled-components/MainDefault";

import ModalPersonalize from "./ModalPersonalize";
import { ArticlesList, Button, Filters, PersonalizeButton } from "./styles";

interface IFilter {
	date?: string;
	keyword?: string;
	category?: string;
	source?: string;
}

interface IResponse {
	message: string;
	data: {
		current_page: number;
		last_page: number;
		per_page: number;
		total: number;
		articles: IArticle[];
	};
}

const ARTICLES_PER_PAGE = 12;

const Dashboard: React.FC = () => {
	const form = useForm();
	const { settings } = useSettings();

	const [articles, setArticles] = useState<IArticle[]>([]);
	const [lastPage, setLastPage] = useState<number>(0);
	const [page, setPage] = useState<number>(1);
	const [filter, setFilter] = useState<IFilter>({} as IFilter);
  const [isModalOpen, setIsModalOpen] = useState(false);

	const handleSubmitFilter = useCallback(
		async ({ date, keyword, category, source }: IFilter) => {
			setFilter({
				date: date || undefined,
				keyword: keyword || undefined,
				category: category || undefined,
				source: source || undefined,
			});
		},
		[form]
	);

	const handleChangePagination = (
		event: React.ChangeEvent<unknown>,
		value: number
	) => {
		setPage(value);
	};

	const fieldsFilter: IGridField[] = [
		{
			gridSize: {
				lg: 3,
				md: 6,
				sm: 12,
			},
			type: "text",
			name: "keyword",
			label: "Keywords",
		},
		{
			gridSize: {
				lg: 3,
				md: 6,
				sm: 12,
			},
			type: "text",
			name: "category",
			label: "Category",
			placeholder: "crypto",
		},
		{
			gridSize: {
				lg: 3,
				md: 6,
				sm: 12,
			},
			type: "text",
			name: "source",
			label: "Source",
			placeholder: "The Guardian",
		},
		{
			gridSize: {
				lg: 3,
				md: 6,
				sm: 12,
			},
			type: "date",
			name: "date",
			label: "Date",
		},
	];

	const removeUnnecessaryParams = useCallback((params:any) => {
		Object.keys(params).forEach((key) => {
			if (params[key] === undefined || (Array.isArray(params[key]) && params[key].length === 0) ) {
				delete params[key];
			}
		});

		return params;
	}, []);

	const buildParams = useCallback(():{} => {
		let params: {} = {
			per_page: ARTICLES_PER_PAGE,
			page: page.toString(),
			...settings,
			...filter,
		};
		
		params = removeUnnecessaryParams(params);
		params = serializeParams(params);

		return params;
	}, [page, filter, settings]);

	const executeFilter = useCallback(async () => {
		let toast = new Toast().loading("Loading articles...");

		await api.get(`/articles?${buildParams()}`)
			.then((response) => {
				let data = response.data as IResponse;
				setLastPage(data.data.last_page);
				setArticles(data.data.articles);

				toast.dismiss();
			})
			.catch((error) => {
				toast.error("Error loading articles!");
			});
	}, [page, lastPage, filter, settings]);

	const openModal = useCallback(() => {
		setIsModalOpen(true);
	}, []);

	useEffect(() => {
		executeFilter()
	}, [page, lastPage, filter, settings]);

	return (
		<MainDefault>
			<Filters>

				<FormUnform ref={form.ref} onSubmit={handleSubmitFilter}>
					<FormBuilder fields={fieldsFilter} />

					<Button
						variant='contained'
						type='submit'
						endIcon={<SendIcon />}>
						Filter
					</Button>

					<PersonalizeButton
						variant='contained'
						color="info"
						type='button'
						onClick={openModal}
						endIcon={<MdOutlineDashboardCustomize />}>
						Customize
					</PersonalizeButton>
				</FormUnform>

			</Filters>

			<ArticlesList>
				{articles.map((article, index) => (
					<Article key={article.id} article={article} />
				))}
			</ArticlesList>

			{articles.length > 0 && (
				<Pagination
					count={lastPage}
					color='primary'
					onChange={handleChangePagination}
				/>
			)}

			<ModalPersonalize 
				isOpen={isModalOpen} 
				setIsOpen={setIsModalOpen}
				executeFilter={executeFilter}
			/>
		</MainDefault>
	);
};

export default Dashboard;
