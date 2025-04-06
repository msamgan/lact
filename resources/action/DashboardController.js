// Action file: DashboardController
export const dashboardData = () => {
	return fetch(route('dashboard.data')).then(response => response)
}

export const dashboardDataTag = () => {
	return fetch(route('dashboard.data.tag')).then(response => response)
}

