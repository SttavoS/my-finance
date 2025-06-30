export function useFetch() {
  async function GET(url: string) {
    const response = await fetch(url, {
      method: 'GET',
      credentials: 'include',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
    });
    return await response.json();
  }

  async function POST(url: string, data: any) {
    const response = await fetch(url, {
      method: 'POST',
      credentials: 'include',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      body: JSON.stringify(data),
    });
  }

  async function PUT(url: string, data: any) {
    const response = await fetch(url, {
      method: 'PUT',
      credentials: 'include',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      body: JSON.stringify(data),
    });

    return await response.json();
  }

  async function DELETE(url: string) {
    await fetch(url, {
      method: 'DELETE',
      credentials: 'include',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
    });
  }

  return { GET, POST, PUT, DELETE };
}
